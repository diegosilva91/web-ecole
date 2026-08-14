<?php

namespace Mi-empresa\Api\Application\PaymentsEvent\Task;

use App\PaymentsEvent;
use Mi-empresa\Api\Application\Payments\InvoicesSubscriptionsProcessing\InvoicesSubscriptionsProcessingCommand;

class InvoicesSubscriptionsProcessingTask extends Task
{
    public function apply(PaymentsEvent $event): bool
    {
        return ($event->event_type == 'payment_intent.processing');
    }

    public function doExecute(PaymentsEvent $event): void
    {
        $command = new InvoicesSubscriptionsProcessingCommand($event);
        $this->commandBus->dispatch($command);
    }
}
