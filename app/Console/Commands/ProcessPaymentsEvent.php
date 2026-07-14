<?php

namespace App\Console\Commands;

use App\PaymentsEvent;
use Illuminate\Console\Command;
use Lifecole\Api\Application\PaymentsEvent\Task\ChargeDisputedTask;
use Lifecole\Api\Application\PaymentsEvent\Task\InvoicesSubscriptionsFailedTask;
use Lifecole\Api\Application\PaymentsEvent\Task\InvoicesSubscriptionsProcessingTask;
use Lifecole\Api\Application\PaymentsEvent\Task\InvoicesSubscriptionsSucceededTask;
use Lifecole\Api\Application\PaymentsEvent\Task\InvoicesSubscriptionsFinalizedTask;
use Lifecole\Api\Application\PaymentsEvent\Task\SepaChargeFailedUpdateTask;
use Lifecole\Api\Application\PaymentsEvent\Task\SepaChargeSucceededUpdateTask;
use Lifecole\Api\Domain\Repository\PaymentsEventRepository;
use Lifecole\Event\Domain\Bus\Command\CommandBus;

class ProcessPaymentsEvent extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stripe:process_events';

    /**
     * The console command description.
     */
    protected $description = 'Process the events of Stripe';

    public function __construct(
        private PaymentsEventRepository $paymentsEventRepository,
        private CommandBus              $commandBus
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $tasks = [
            new InvoicesSubscriptionsFinalizedTask($this->paymentsEventRepository, $this->commandBus),
            new InvoicesSubscriptionsProcessingTask($this->paymentsEventRepository, $this->commandBus),
            new InvoicesSubscriptionsSucceededTask($this->paymentsEventRepository, $this->commandBus),
            new InvoicesSubscriptionsFailedTask($this->paymentsEventRepository, $this->commandBus),
            new SepaChargeSucceededUpdateTask($this->paymentsEventRepository, $this->commandBus),
            new SepaChargeFailedUpdateTask($this->paymentsEventRepository, $this->commandBus),
            new ChargeDisputedTask($this->paymentsEventRepository, $this->commandBus),
        ];

        $events = PaymentsEvent::where(['status' => PaymentsEvent::STATUS_PENDING])->limit(200)->get();
        dump(count($events));

        foreach ($events as $event) {
            $executed = false;
            foreach ($tasks as $task) {
                if ($task->apply($event)) {
                    $resultExecution = $task->execute($event);
                    $executed = true;

                    if (!$resultExecution) {
                        break;
                    }
                }
            }

            if (!$executed) {
                $this->paymentsEventRepository->update([
                    'id' => $event->id,
                ], [
                    'status' => PaymentsEvent::STATUS_IGNORED
                ]);
            }
        }

        return 0;
    }
}
