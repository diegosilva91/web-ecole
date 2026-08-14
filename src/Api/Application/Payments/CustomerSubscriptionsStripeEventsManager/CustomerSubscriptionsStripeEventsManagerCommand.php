<?php

namespace Mi-empresa\Api\Application\Payments\CustomerSubscriptionsStripeEventsManager;

use Mi-empresa\Event\Domain\Bus\Command\Command;

class CustomerSubscriptionsStripeEventsManagerCommand extends Command
{
    private string $previousStatus;
    private string $status;
    private string $idSubscriptionStripe;
    private string $idCustomer;

    public function __construct(private array $data)
    {
        parent::__construct();

        $this->previousStatus = $data['previous_attributes']['status'] ?? '';
        $this->status = $data['object']['status'];
        $this->idSubscriptionStripe = $data['object']['id'];
        $this->idCustomer = $data['object']['customer'];
    }

    public function data(): array
    {
        return $this->data;
    }

    public function previousStatus(): string
    {
        return $this->previousStatus;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function idSubscription(): string
    {
        return $this->idSubscriptionStripe;
    }

    public function idCustomer(): string
    {
        return $this->idCustomer;
    }

    public function promotionDate(): string
    {
        return $this->data['object']['metadata']['promotion_date'];
    }
}
