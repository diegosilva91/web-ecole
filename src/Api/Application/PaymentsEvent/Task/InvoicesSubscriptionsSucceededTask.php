<?php

namespace Lifecole\Api\Application\PaymentsEvent\Task;

use App\PaymentsEvent;
use Lifecole\Api\Application\Payments\InvoicesSubscriptionsSucceeded\InvoicesSubscriptionsSucceededCommand;

class InvoicesSubscriptionsSucceededTask extends Task
{
    public function apply(PaymentsEvent $event): bool
    {
        $payload = $event->processPayload();
        return ($event->event_type == 'invoice.payment_succeeded' &&
            isset($payload['data']['object']['billing_reason']) &&
            $payload['data']['object']['billing_reason'] === 'subscription_cycle' &&
            $payload['data']['object']['collection_method'] === 'charge_automatically');
    }

    public function doExecute(PaymentsEvent $event): void
    {
        $command = new InvoicesSubscriptionsSucceededCommand($event);
        $this->commandBus->dispatch($command);
    }
}
