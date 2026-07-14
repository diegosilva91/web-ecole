<?php

namespace Lifecole\Api\Application\PaymentsEvent\Task;

use App\PaymentsEvent;
use Lifecole\Api\Application\Payments\ChargeDisputed\ChargeDisputedCommand;

class ChargeDisputedTask extends Task
{
    public function apply(PaymentsEvent $event): bool
    {
        return ($event->event_type == 'charge.dispute.closed');
    }

    public function doExecute(PaymentsEvent $event): void
    {
        $command = new ChargeDisputedCommand($event);
        $this->commandBus->dispatch($command);
    }
}
