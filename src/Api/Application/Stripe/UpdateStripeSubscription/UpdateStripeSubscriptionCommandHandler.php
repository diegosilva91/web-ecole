<?php

namespace Lifecole\Api\Application\Stripe\UpdateStripeSubscription;

use Lifecole\Api\Domain\Repository\StripePaymentsRepository;
use Lifecole\Event\Domain\Bus\Command\CommandHandler;

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
