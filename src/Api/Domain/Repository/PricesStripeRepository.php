<?php

namespace Lifecole\Api\Domain\Repository;

use App\PricesStripe;

interface PricesStripeRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?PricesStripe;
}
