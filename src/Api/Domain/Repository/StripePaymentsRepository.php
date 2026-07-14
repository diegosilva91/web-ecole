<?php

namespace Lifecole\Api\Domain\Repository;

interface StripePaymentsRepository
{
    public function getCustomer(?string $email): array;

    public function getSubscription($customerId, $subscriptionId): array;

    public function updateSubscription($customerId, $subscriptionId, $dataUpdate): array;
}
