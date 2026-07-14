<?php

namespace Lifecole\Api\Domain\Repository;

use Lifecole\Shared\Domain\ValueObject\TeacherId;

interface TeachersRepository
{
    public function updateById(TeacherId $teacherId, array $dataFill);

    public function findById(TeacherId $teacherId): ?object;

    public function updateByColumn(string $columnName, string $columnValue, $dataFill);
}
