<?php

namespace Mi-empresa\Api\Application\Paypal;

use App\PromotionPurchasePayment;
use Mi-empresa\Api\Domain\DTO\PaypalPayment;
use Mi-empresa\Event\Domain\Bus\Command\Command;

class UpdatePaymentPaypalCommand extends Command
{
    public function __construct(private PaypalPayment $paypalPayment, private PromotionPurchasePayment $promotionPurchasePayment)
    {
        parent::__construct();
    }

    public function paypalPayment(): PaypalPayment
    {
        return $this->paypalPayment;
    }

    public function promotionPurchasePayment(): PromotionPurchasePayment
    {
        return $this->promotionPurchasePayment;
    }
}
