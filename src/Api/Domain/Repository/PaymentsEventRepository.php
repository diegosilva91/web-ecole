<?php

namespace Mi-empresa\Api\Domain\Repository;

interface PaymentsEventRepository
{
    public function update(array $dataFind, array $dataUpdate): void;

    public function updateOrCreate(array $dataFind, array $dataUpdate): void;
}
