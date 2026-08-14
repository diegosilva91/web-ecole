<?php

namespace Mi-empresa\Api\Application\Payments\SepaChargeFailedUpdateCommand;

use App\Course;
use App\Mail\Internal\PaymentSepaFailed;
use App\PromotionPurchase;
use App\PromotionPurchasePayment;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Mi-empresa\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class SepaChargeFailedUpdateCommandHandler implements CommandHandler
{
    public function __construct(
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
    ) {
    }

    public function __invoke(SepaChargeFailedUpdateCommand $sepaChargeFailedUpdateCommand)
    {
        $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findByPaymentIntentAndPaymentStatus($sepaChargeFailedUpdateCommand->paymentIntentId(), ['pending','prepared']);
        $promotionPurchase = $promotionPurchasePayment->promotionPurchase();

        $reasonFail = '';
        try {
            $paymentIntent = Stripe::paymentIntents()->find($sepaChargeFailedUpdateCommand->paymentIntentId());
            $reasonFail = $paymentIntent['last_payment_error']['message'];
        } catch (\Throwable $e) {
        }

        $promotionPurchasePayment->payment_status = 'failed';
        $promotionPurchasePayment->payment_status_error = Str::limit($reasonFail, 180);
        $promotionPurchasePayment->save();

        /*
         * Actualizamos los estados de la compra en función de los estados del pago
         */

        $paid = PromotionPurchase::PAID_PENDING;
        $active = PromotionPurchase::ACTIVE_YES;
        $payments = $promotionPurchase->payments();
        /** @var PromotionPurchasePayment $payment */
        foreach ($payments as $payment) {
            if ($payment->payment_status === 'succeeded') {
                $paid = PromotionPurchase::PAID_PAID;
            }
            if ($payment->payment_status !== 'succeeded') {
                $active = PromotionPurchase::ACTIVE_NO;
            }
        }
        $promotionPurchase->paid = $paid;
        $promotionPurchase->active = $active;
        $promotionPurchase->save();

        $promotion = $promotionPurchase->promotion();
        $user = $promotionPurchase->user();
        /** @var Course $course */
        $course = $promotion->course()->first();
        Mail::send(new PaymentSepaFailed(
            $promotionPurchasePayment,
            $course, $user, $promotion, [
                'payment' => $sepaChargeFailedUpdateCommand->paymentIntentId(),
                'event' => $sepaChargeFailedUpdateCommand->chargeId(),
                'reasonFail' => $reasonFail
            ]
        ));
    }
}
