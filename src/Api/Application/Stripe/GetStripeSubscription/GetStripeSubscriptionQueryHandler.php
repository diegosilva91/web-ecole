<?php

namespace Lifecole\Api\Application\Stripe\GetStripeSubscription;

use Lifecole\Api\Domain\Repository\StripePaymentsRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

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
