<?php

namespace Lifecole\Api\Application\Stripe\GetStripeSubscription;

use Lifecole\Event\Domain\Bus\Query\Query;

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
