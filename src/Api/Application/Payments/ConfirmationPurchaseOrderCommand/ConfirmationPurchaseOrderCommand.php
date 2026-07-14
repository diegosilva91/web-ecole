<?php

namespace Lifecole\Api\Application\Payments\ConfirmationPurchaseOrderCommand;

use App\PromotionPurchasePayment;
use Lifecole\Event\Domain\Bus\Command\Command;

class ConfirmationPurchaseOrderCommand extends Command
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
