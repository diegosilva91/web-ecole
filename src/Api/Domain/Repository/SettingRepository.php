<?php

declare(strict_types=1);

namespace Mi-empresa\Api\Domain\Repository;

use App\Setting;

interface SettingRepository
{
    public function findById(int $id): ?Setting;

    public function findByKey(string $key): ?Setting;
}
