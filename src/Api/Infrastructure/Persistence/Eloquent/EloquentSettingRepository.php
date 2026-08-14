<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\Setting;
use Mi-empresa\Api\Domain\Repository\SettingRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

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
