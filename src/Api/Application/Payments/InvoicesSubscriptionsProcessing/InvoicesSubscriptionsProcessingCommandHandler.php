<?php

namespace Lifecole\Api\Application\Payments\InvoicesSubscriptionsProcessing;

use Lifecole\Api\Domain\Repository\PromotionPurchasePaymentRepository;

class InvoicesSubscriptionsProcessingCommandHandler
{
    public function __construct(
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
    ) {
    }

    public function __invoke(InvoicesSubscriptionsProcessingCommand $invoicesSubscriptionsProcessingCommand)
    {
        $paymentIntentToken = $invoicesSubscriptionsProcessingCommand->paymentIntent();
        $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findByPaymentIntentAndPaymentStatus($paymentIntentToken, ['prepared','failed','succeeded','pending']);

        if (isset($promotionPurchasePayment)) {
            if ($promotionPurchasePayment->payment_status != 'succeeded' && $promotionPurchasePayment->payment_status != 'pending') {
                echo "Intento cambiar $promotionPurchasePayment->id\n";
                $promotionPurchasePayment->payment_status = 'pending';
                $promotionPurchasePayment->payment_status_error = null;
                $promotionPurchasePayment->save();
            } else {
                echo "En correcto estado $promotionPurchasePayment->id\n";
            }
        } else {
            throw new \Exception('No se ha encontrado el pago: ' . $paymentIntentToken);
        }
    }
}
