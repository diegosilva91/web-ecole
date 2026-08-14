<?php

namespace Mi-empresa\Api\Application\Stripe\UpdateStripeSubscription;

use Mi-empresa\Api\Domain\Repository\StripePaymentsRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

class UpdateStripeSubscriptionCommandHandler implements CommandHandler
{
    public function __construct(private StripePaymentsRepository $stripePaymentsRepository)
    {
    }

    public function __invoke(UpdateStripeSubscriptionCommand $updateStripeSubscriptionCommand)
    {
        return $this->stripePaymentsRepository
            ->updateSubscription(
                $updateStripeSubscriptionCommand->customerId(),
                $updateStripeSubscriptionCommand->subscriptionId(),
                $updateStripeSubscriptionCommand->dataUpdate()
            );
    }
}
