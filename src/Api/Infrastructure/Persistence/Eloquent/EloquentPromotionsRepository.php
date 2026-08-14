<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentPromotionsRepository extends EloquentRepository
{

    protected function model(): string
    {
        return Promotion::class;
    }
}