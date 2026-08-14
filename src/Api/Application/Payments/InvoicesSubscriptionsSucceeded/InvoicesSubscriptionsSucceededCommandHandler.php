<?php

namespace Mi-empresa\Api\Application\Payments\InvoicesSubscriptionsSucceeded;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Mi-empresa\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class InvoicesSubscriptionsSucceededCommandHandler implements CommandHandler
{
    public function __construct(
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
    ) {
    }

    public function __invoke(InvoicesSubscriptionsSucceededCommand $invoicesSubscriptionsSucceededCommand)
    {
        $subscriptionToken = $invoicesSubscriptionsSucceededCommand->subscriptionToken();
        $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findPreparedSubscriptionByToken($subscriptionToken);

        try {
            $paymentIntent = Stripe::paymentIntents()->find($invoicesSubscriptionsSucceededCommand->paymentIntent());
        } catch (\Throwable $e) {
        }

        if (isset($promotionPurchasePayment)) {
            $promotionPurchasePayment->payment_status = 'succeeded';
            $promotionPurchasePayment->payment_status_error = null;
            $promotionPurchasePayment->stripe_payment_intent_token = $invoicesSubscriptionsSucceededCommand->paymentIntent();
            $promotionPurchasePayment->stripe_transaction_token = $paymentIntent['charges']['data'][0]['balance_transaction'];
            $promotionPurchasePayment->paid_at = (new \DateTime())->setTimestamp($invoicesSubscriptionsSucceededCommand->paidAt());

            $promotionPurchasePayment->save();
        } else {
            throw new \Exception('No se ha encontrado la suscripción: ' . $subscriptionToken);
        }
    }
}
