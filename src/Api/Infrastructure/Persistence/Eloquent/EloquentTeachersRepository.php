<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\Teacher;
use Illuminate\Contracts\Support\Arrayable;
use Lifecole\Api\Domain\Repository\TeachersRepository;
use Lifecole\Shared\Domain\ValueObject\TeacherId;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentTeachersRepository extends EloquentRepository implements TeachersRepository
{
    public function updateById(TeacherId $teacherId, array $dataFill)
    {
        $model = $this->model->find($teacherId->value());
        $model->update($dataFill);
    }

    public function updateByColumn(string $columnName, string $columnValue, $dataFill)
    {
        if (!is_array($columnValue) && !$columnValue instanceof Arrayable) {
            $model = $this->model->where($columnName, $columnValue, '=');
            $model->update($dataFill);
        }
    }

    public function findById(TeacherId $teacherId): object|null
    {
        return $this->model->find($teacherId->value());
    }

    protected function model(): string
    {
        return Teacher::class;
    }
}
