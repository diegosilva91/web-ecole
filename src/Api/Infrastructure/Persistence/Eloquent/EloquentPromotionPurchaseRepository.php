<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\PromotionPurchase;
use Lifecole\Api\Domain\Repository\PromotionPurchaseRepository;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

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
