<?php

namespace Lifecole\Api\Application\Payments\InvoicesSubscriptionsFailed;

use App\Course;
use App\Mail\Internal\PaymentSubscriptionFailed;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Lifecole\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Lifecole\Event\Domain\Bus\Command\CommandHandler;

class InvoicesSubscriptionsFailedCommandHandler implements CommandHandler
{
    public function __construct(
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
    ) {
    }

    public function __invoke(InvoicesSubscriptionsFailedCommand $invoicesSubscriptionsFailedCommand)
    {
        $subscriptionToken = $invoicesSubscriptionsFailedCommand->subscriptionToken();

        $reasonFail = '';
        try {
            $paymentIntent = Stripe::paymentIntents()->find($invoicesSubscriptionsFailedCommand->paymentIntent());
            $reasonFail = $paymentIntent['last_payment_error']['message'];
        } catch (\Throwable $e) {
        }

        $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findPreparedSubscriptionByToken($subscriptionToken);
        $promotionPurchasePayment->payment_status = 'failed';
        $promotionPurchasePayment->payment_status_error = Str::limit($reasonFail, 180);
        $promotionPurchasePayment->stripe_payment_intent_token = $paymentIntent['id'];
        $promotionPurchasePayment->save();

        $promotionPurchase = $promotionPurchasePayment->promotionPurchase();
        $promotion = $promotionPurchase->promotion();
        $user = $promotionPurchase->user();
        /** @var Course $course */
        $course = $promotion->course()->first();

        Mail::send(new PaymentSubscriptionFailed(
            $promotionPurchasePayment, $course, $user, $promotion, [
                'subscription' => $subscriptionToken,
                'payment' => $invoicesSubscriptionsFailedCommand->paymentIntent(),
                'event' => $invoicesSubscriptionsFailedCommand->eventId(),
                'price' => ($invoicesSubscriptionsFailedCommand->price() / 100),
                'periodStart' => (new \DateTime())->setTimestamp($invoicesSubscriptionsFailedCommand->periodStart())->format('d-m-Y'),
                'periodEnd' => (new \DateTime())->setTimestamp($invoicesSubscriptionsFailedCommand->periodEnd())->format('d-m-Y'),
                'reasonFail' => $reasonFail
            ]
        ));
    }
}
