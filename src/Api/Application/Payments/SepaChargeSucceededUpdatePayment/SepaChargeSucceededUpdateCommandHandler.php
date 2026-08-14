<?php

namespace Mi-empresa\Api\Application\Payments\SepaChargeSucceededUpdatePayment;

use App\PromotionPurchase;
use Mi-empresa\Api\Application\Payments\ConfirmationPaymentOrderCommand\ConfirmationPaymentOrderCommand;
use Mi-empresa\Api\Application\Payments\ConfirmationSepaPaymentOrderCommand\ConfirmationSepaPaymentOrderCommand;
use Mi-empresa\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Mi-empresa\Api\Domain\Repository\PromotionPurchaseRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandBus;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class SepaChargeSucceededUpdateCommandHandler implements CommandHandler
{
    public function __construct(
        private PromotionPurchaseRepository        $promotionPurchaseRepository,
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
        private CommandBus                         $commandBus
    ) {
    }

    public function __invoke(SepaChargeSucceededUpdateCommand $sepaChargeSucceededUpdateCommand)
    {
        $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findByPaymentIntentAndPaymentStatus($sepaChargeSucceededUpdateCommand->paymentIntentId(), ['pending','prepared']);
        $promotionPurchase = $promotionPurchasePayment->promotionPurchase();

        $this->promotionPurchasePaymentRepository->update([
            'id' => $promotionPurchasePayment->id
        ], [
            'payment_status' => 'succeeded',
            'paid_at' => new \DateTime()
        ]);

        $this->promotionPurchaseRepository->update([
            'id' => $promotionPurchase->id
        ], [
            'paid' => PromotionPurchase::PAID_PAID,
            'active' => PromotionPurchase::ACTIVE_YES,
        ]);

        $this->commandBus->dispatch(
            new ConfirmationPaymentOrderCommand($promotionPurchasePayment)
        );

        $this->commandBus->dispatch(
            new ConfirmationSepaPaymentOrderCommand($promotionPurchasePayment)
        );
    }
}
