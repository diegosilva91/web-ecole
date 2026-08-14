<?php

namespace Mi-empresa\Api\Application\Payments\ConfirmationSepaPaymentOrderCommand;

use App\PromotionPurchasePayment;
use Mi-empresa\Event\Domain\Bus\Command\Command;

class ConfirmationSepaPaymentOrderCommand extends Command
{
    public function __construct(
        private PromotionPurchasePayment $promotionPurchasePayment
    ) {
        parent::__construct();
    }

    public function promotionPurchasePayment(): PromotionPurchasePayment
    {
        return $this->promotionPurchasePayment;
    }
}
