<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\CourseSpecialization;
use Lifecole\Api\Domain\Repository\CourseSpecializationRepository;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCourseSpecializationRepository extends EloquentRepository implements CourseSpecializationRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?CourseSpecialization
    {
        $model = $this->model->when(isset($filtersColumns), function ($query) use ($filtersColumns) {
            return $query->where($filtersColumns);
        });
        if (isset($arguments_get) && count($arguments_get)) {
            $model = $model->select($arguments_get);
        }
        return optional($model)->first();
    }

    protected function model(): string
    {
        return CourseSpecialization::class;
    }
}
