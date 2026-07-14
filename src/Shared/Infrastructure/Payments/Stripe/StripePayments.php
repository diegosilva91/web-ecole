<?php

namespace Lifecole\Shared\Infrastructure\Payments\Stripe;

use Lifecole\Api\Domain\Repository\StripePaymentsRepository;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class StripePayments implements StripePaymentsRepository
{
    public function getCustomer(?string $email): array
    {
        if (isset($email)) {
            $list = Stripe::customers()->all(['email' => $email]);
            if (count($list['data']) > 0) {
                $customer = $list['data'][0];
            } else {
                $customer = Stripe::customers()->create(['email' => $email]);
            }
        } else {
            $customer = Stripe::customers()->create();
        }
        return $customer;
    }

    public function getSubscription($customerId, $subscriptionId): array
    {
        return Stripe::subscriptions()->find($customerId, $subscriptionId);
    }

    public function updateSubscription($customerId, $subscriptionId, $dataUpdate): array
    {
        return Stripe::subscriptions()->update($customerId, $subscriptionId, $dataUpdate);
    }
}
