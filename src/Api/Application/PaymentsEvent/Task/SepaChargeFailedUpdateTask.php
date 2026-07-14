<?php

namespace Lifecole\Api\Application\PaymentsEvent\Task;

use App\PaymentsEvent;
use Lifecole\Api\Application\Payments\SepaChargeFailedUpdateCommand\SepaChargeFailedUpdateCommand;

class SepaChargeFailedUpdateTask extends Task
{
    public function apply(PaymentsEvent $event): bool
    {
        $payload = $event->processPayload();
        return ($event->event_type === 'charge.failed' &&
            isset($payload['data']['object']['payment_method_details']['type'], $payload['data']['object']['status']) &&
            $payload['data']['object']['payment_method_details']['type'] === 'sepa_debit' &&
            $payload['data']['object']['status'] === 'failed');
    }

    public function doExecute(PaymentsEvent $event): void
    {
        $command = new SepaChargeFailedUpdateCommand($event);
        $this->commandBus->dispatch($command);
    }
}
