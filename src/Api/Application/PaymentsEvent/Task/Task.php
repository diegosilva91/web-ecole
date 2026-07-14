<?php

namespace Lifecole\Api\Application\PaymentsEvent\Task;

use App\Mail\Internal\ReportCommandError;
use App\PaymentsEvent;
use Illuminate\Support\Facades\Mail;
use Lifecole\Api\Domain\Repository\PaymentsEventRepository;
use Lifecole\Event\Domain\Bus\Command\CommandBus;

abstract class Task
{
    public function __construct(protected PaymentsEventRepository $paymentsEventRepository, protected CommandBus $commandBus)
    {
    }

    abstract public function apply(PaymentsEvent $event): bool;

    public function execute(PaymentsEvent $event): bool
    {
        try {
            $this->doExecute($event);
            $this->finishSucceeded($event);
            return true;
        } catch (\Throwable $e) {
            try {
                Mail::send(new ReportCommandError(static::class, ['event' => $event->id], $e));
            } catch (\Throwable $throwableToIgnore) {
            }

            $this->finishFailed($event);
            return false;
        }
    }

    protected function finishSucceeded(PaymentsEvent $event)
    {
        $this->paymentsEventRepository->update([
            'id' => $event->id,
        ], [
            'status' => PaymentsEvent::STATUS_SUCCEEDED
        ]);
    }

    protected function finishFailed(PaymentsEvent $event)
    {
        $this->paymentsEventRepository->update([
            'id' => $event->id,
        ], [
            'status' => PaymentsEvent::STATUS_FAILED
        ]);
    }

    abstract public function doExecute(PaymentsEvent $event): void;
}
