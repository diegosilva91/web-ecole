<?php

namespace Lifecole\Api\Application\Payments\InvoicesSubscriptionsFinalized;

use Lifecole\Api\Domain\Repository\PromotionPurchasePaymentRepository;

class InvoicesSubscriptionsFinalizedCommandHandler
{
    public function __construct(
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
    ) {
    }

    public function __invoke(InvoicesSubscriptionsFinalizedCommand $invoicesSubscriptionsFinalizedCommand)
    {
        $subscriptionToken = $invoicesSubscriptionsFinalizedCommand->subscriptionToken();
        $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findPaymentBySubscriptionAndStatus($subscriptionToken, ['prepared']);

        if (isset($promotionPurchasePayment)) {
            if ($promotionPurchasePayment->stripe_payment_intent_token == null) {
                $promotionPurchasePayment->stripe_payment_intent_token = $invoicesSubscriptionsFinalizedCommand->paymentIntent();
                $promotionPurchasePayment->save();
            }
        } else {
            throw new \Exception('No se ha encontrado la suscripción: ' . $subscriptionToken);
        }
    }
}
