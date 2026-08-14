<?php

namespace Mi-empresa\Api\Application\PaymentsEvent\Task;

use App\PaymentsEvent;
use Mi-empresa\Api\Application\Payments\InvoicesSubscriptionsFinalized\InvoicesSubscriptionsFinalizedCommand;

class InvoicesSubscriptionsFinalizedTask extends Task
{
    public function apply(PaymentsEvent $event): bool
    {
        $payload = $event->processPayload();
        return ($event->event_type == 'invoice.finalized' &&
            isset($payload['data']['object']['billing_reason']) &&
            $payload['data']['object']['billing_reason'] === 'subscription_cycle' &&
            $payload['data']['object']['collection_method'] === 'charge_automatically')
            ;
    }

    public function doExecute(PaymentsEvent $event): void
    {
        $command = new InvoicesSubscriptionsFinalizedCommand($event);
        $this->commandBus->dispatch($command);
    }
}
