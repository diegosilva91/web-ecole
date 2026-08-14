<?php

namespace Mi-empresa\Api\Application\Payments\InvoicesSubscriptionsFailed;

use App\PaymentsEvent;
use Mi-empresa\Event\Domain\Bus\Command\Command;

class InvoicesSubscriptionsFailedCommand extends Command
{
    private array $payload;

    public function __construct(
        PaymentsEvent $paymentEvent
    )
    {
        parent::__construct();

        $this->payload = $paymentEvent->processPayload();
    }

    public function subscriptionToken(): string
    {
        return $this->payload['data']['object']['subscription'];
    }

    public function eventId(): string
    {
        return $this->payload['id'];
    }

    public function paymentIntent(): string
    {
        return $this->payload['data']['object']['payment_intent'];
    }

    public function price(): string
    {
        return $this->payload['data']['object']['total'];
    }

    public function periodStart(): string
    {
        return $this->payload['data']['object']['period_start'];
    }

    public function periodEnd(): string
    {
        return $this->payload['data']['object']['period_end'];
    }
}
