<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\PromotionPurchase;
use Mi-empresa\Api\Domain\Repository\PromotionPurchaseRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentPromotionPurchaseRepository extends EloquentRepository implements PromotionPurchaseRepository
{
    public function createByData(array $data)
    {
        $this->model->create($data);
    }

    public function update(array $dataFind, array $dataUpdate): void
    {
        $model = PromotionPurchase::where($dataFind);
        $model->update($dataUpdate);
    }

    protected function model(): string
    {
        return PromotionPurchase::class;
    }
}
