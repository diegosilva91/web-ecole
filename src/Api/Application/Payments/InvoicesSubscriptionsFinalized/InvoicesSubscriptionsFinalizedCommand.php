<?php

namespace Lifecole\Api\Application\Payments\InvoicesSubscriptionsFinalized;

use App\PaymentsEvent;
use Lifecole\Event\Domain\Bus\Command\Command;

class InvoicesSubscriptionsFinalizedCommand extends Command
{
    private array $payload;

    public function __construct(
        PaymentsEvent $paymentEvent
    )
    {
        parent::__construct();

        $this->payload = $paymentEvent->processPayload();
    }

    public function due(): int
    {
        return ($this->payload['data']['object']['amount_due'] / 100);
    }

    public function periodStart(): string
    {
        return $this->payload['data']['object']['lines']['data'][0]['period']['start'];
    }

    public function periodEnd(): string
    {
        return $this->payload['data']['object']['lines']['data'][0]['period']['end'];
    }

    public function paymentIntent(): string
    {
        return $this->payload['data']['object']['payment_intent'];
    }

    public function customer(): string
    {
        return $this->payload['data']['object']['customer'];
    }

    public function subscriptionToken(): string
    {
        return $this->payload['data']['object']['subscription'];
    }
}
