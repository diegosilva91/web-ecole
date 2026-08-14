<?php

namespace Mi-empresa\Api\Application\Payments\ConfirmationPaymentOrderCommand;

use App\PromotionPurchasePayment;
use Mi-empresa\Event\Domain\Bus\Command\Command;

class ConfirmationPaymentOrderCommand extends Command
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
