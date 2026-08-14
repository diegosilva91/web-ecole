<?php

namespace Mi-empresa\Api\Application\Payments\CustomerSubscriptionsStripeEventsManager;

use Carbon\Carbon;
use Mi-empresa\Api\Application\Stripe\GetStripeSubscription\GetStripeSubscriptionQuery;
use Mi-empresa\Api\Application\Stripe\UpdateStripeSubscription\UpdateStripeSubscriptionCommand;
use Mi-empresa\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandBus;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;

class CustomerSubscriptionsStripeEventsManagerCommandHandler implements CommandHandler
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus,
        private PromotionPurchasePaymentRepository $promotionPurchasePaymentRepository,
    ) {
    }

    public function __invoke(CustomerSubscriptionsStripeEventsManagerCommand $customerSubscriptionsStripeEventsManagerCommand)
    {
        $idStripeSubscription = $customerSubscriptionsStripeEventsManagerCommand->idSubscription();
        $idStripeCustomer = $customerSubscriptionsStripeEventsManagerCommand->idCustomer();
        $stripeSubscription = $this->queryBus->ask(
            new GetStripeSubscriptionQuery($idStripeSubscription, $idStripeCustomer)
        );

        if ($this->checkSubscriptionValid(
            $customerSubscriptionsStripeEventsManagerCommand->previousStatus(),
            $customerSubscriptionsStripeEventsManagerCommand->status(),
            $stripeSubscription
        )
        ) {
            $promotionPurchasePayment = $this->promotionPurchasePaymentRepository->findBySubscriptionToken($idStripeSubscription);
            $promotionPurchase = $promotionPurchasePayment->promotionPurchase();
            $promotion = $promotionPurchase->promotion();

            $rand = rand(1,3600);

            $trial_end = Carbon::parse($promotion->start_at)->endOfMonth()->timestamp;
            $trial_end = $trial_end - (13 * 3600) + $rand; // 12:00 CET
            $dataUpdate = [
                'trial_end' => $trial_end,
                'proration_behavior' => 'none',
            ];
            $this->commandBus->dispatch(
                new UpdateStripeSubscriptionCommand($idStripeCustomer, $idStripeSubscription, $dataUpdate)
            );
        }
    }

    private function checkSubscriptionValid($previousStatus, $status, $stripeSubscription): bool
    {
        return $previousStatus === 'incomplete' && $status === 'active' && isset($stripeSubscription);
    }
}
