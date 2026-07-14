<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\Setting;
use Lifecole\Api\Domain\Repository\SettingRepository;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentSettingRepository extends EloquentRepository implements SettingRepository
{
    public function findById(int $id): ?Setting
    {
        return $this->model->find($id);
    }

    public function findByKey(string $key): ?Setting
    {
        return $this->model->where(['key' => $key])->first();
    }

    protected function model(): string
    {
        return Setting::class;
    }
}
