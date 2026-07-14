<?php

namespace Lifecole\Api\Application\Payments\ConfirmationSepaPaymentOrderCommand;

use App\PromotionPurchasePayment;
use Lifecole\Event\Domain\Bus\Command\Command;

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
