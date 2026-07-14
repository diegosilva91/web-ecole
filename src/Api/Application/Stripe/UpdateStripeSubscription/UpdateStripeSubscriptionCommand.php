<?php

namespace Lifecole\Api\Application\Stripe\UpdateStripeSubscription;

use Lifecole\Event\Domain\Bus\Command\Command;

class UpdateStripeSubscriptionCommand extends Command
{
    public function __construct(private string $customerId, private string $subscriptionId, private array $dataUpdate)
    {
        parent::__construct();
    }

    public function subscriptionId(): string
    {
        return $this->subscriptionId;
    }

    public function dataUpdate(): array
    {
        return $this->dataUpdate;
    }

    public function customerId(): string
    {
        return $this->customerId;
    }
}
