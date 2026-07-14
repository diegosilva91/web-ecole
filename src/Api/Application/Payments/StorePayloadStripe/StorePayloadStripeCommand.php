<?php

namespace Lifecole\Api\Application\Payments\StorePayloadStripe;

use App\PaymentsEvent;
use Lifecole\Event\Domain\Bus\Command\Command;

class StorePayloadStripeCommand extends Command
{
    public function __construct(private array $data, private int $status = PaymentsEvent::STATUS_PENDING)
    {
        parent::__construct();
    }

    public function data(): array
    {
        return $this->data;
    }

    public function status(): int
    {
        return $this->status;
    }
}
