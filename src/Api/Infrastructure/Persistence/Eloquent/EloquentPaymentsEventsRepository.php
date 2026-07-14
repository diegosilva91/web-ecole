<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\PaymentsEvent;
use Lifecole\Api\Domain\Repository\PaymentsEventRepository;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentPaymentsEventsRepository extends EloquentRepository implements PaymentsEventRepository
{
    public function update(array $dataFind, array $dataUpdate): void
    {
        $model = PaymentsEvent::where($dataFind);
        if (empty($dataUpdate['status'])) {
            $dataUpdate['status'] = PaymentsEvent::STATUS_PENDING;
        }
        $model->update($dataUpdate);
    }

    public function updateOrCreate(array $dataFind, array $dataUpdate): void
    {
        $model = new $this->model();
        if (empty($dataUpdate['status'])) {
            $dataUpdate['status'] = PaymentsEvent::STATUS_PENDING;
        }
        $model->updateOrCreate($dataFind, $dataUpdate);
    }

    protected function model(): string
    {
        return PaymentsEvent::class;
    }
}
