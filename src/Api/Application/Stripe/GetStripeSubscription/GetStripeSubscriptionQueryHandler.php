<?php

namespace Mi-empresa\Api\Application\Stripe\GetStripeSubscription;

use Mi-empresa\Api\Domain\Repository\StripePaymentsRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetStripeSubscriptionQueryHandler implements QueryHandler
{
    public function __construct(private StripePaymentsRepository $stripePaymentsRepository)
    {
    }

    public function __invoke(GetStripeSubscriptionQuery $getStripeSubscriptionQuery)
    {
        return $this->stripePaymentsRepository->getSubscription(
            $getStripeSubscriptionQuery->stripeCustomerId(),
            $getStripeSubscriptionQuery->stripeSubscriptionId()
        );
    }
}
