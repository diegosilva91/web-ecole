<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentPromotionsRepository extends EloquentRepository
{

    protected function model(): string
    {
        return Promotion::class;
    }
}