<?php

namespace Mi-empresa\Api\Domain\Repository;

interface PromotionPurchaseRepository
{
    public function createByData(array $data);

    public function update(array $dataFind, array $dataUpdate): void;
}
