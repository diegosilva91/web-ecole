<?php

namespace Mi-empresa\Api\Application\Stripe\GetStripeSubscription;

use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetStripeSubscriptionQuery extends Query
{
    public function __construct(private string $stripeSubscriptionId, private string $stripeCustomerId)
    {
        parent::__construct();
    }

    public function stripeSubscriptionId(): string
    {
        return $this->stripeSubscriptionId;
    }

    public function stripeCustomerId(): string
    {
        return $this->stripeCustomerId;
    }
}
