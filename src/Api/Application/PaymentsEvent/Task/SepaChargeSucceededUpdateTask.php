<?php

namespace Mi-empresa\Api\Application\PaymentsEvent\Task;

use App\PaymentsEvent;
use Mi-empresa\Api\Application\Payments\SepaChargeSucceededUpdatePayment\SepaChargeSucceededUpdateCommand;

class SepaChargeSucceededUpdateTask extends Task
{
    public function apply(PaymentsEvent $event): bool
    {
        $payload = $event->processPayload();
        return ($event->event_type === 'charge.succeeded' &&
            isset($payload['data']['object']['payment_method_details']['type'], $payload['data']['object']['status']) &&
            $payload['data']['object']['payment_method_details']['type'] === 'sepa_debit' &&
            $payload['data']['object']['status'] === 'succeeded');
    }

    public function doExecute(PaymentsEvent $event): void
    {
        $command = new SepaChargeSucceededUpdateCommand($event);
        $this->commandBus->dispatch($command);
    }
}
