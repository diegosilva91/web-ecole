<?php

namespace Lifecole\Api\Domain\DTO;

class PaypalPayment
{
    public function __construct(private ?string $payerId, private ?array $payments_paypal)
    {
    }

    public static function createFromPayment(?string $payerId, ?array $payments_paypal): self
    {
        return new self($payerId, $payments_paypal);
    }

    public function payerId(): ?string
    {
        return $this->payerId;
    }

    public function paymentsPaypal(): ?array
    {
        return $this->payments_paypal;
    }
}