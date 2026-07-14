<?php

namespace Lifecole\Api\Application\Payments\ChargeDisputed;

use App\PaymentsEvent;
use Lifecole\Event\Domain\Bus\Command\Command;

class ChargeDisputedCommand extends Command
{
    private array $payload;

    public function __construct(
        PaymentsEvent $paymentEvent
    )
    {
        parent::__construct();

        $this->payload = $paymentEvent->processPayload();
    }

    public function paymentIntent(): string
    {
        return $this->payload['data']['object']['payment_intent'];
    }
}
