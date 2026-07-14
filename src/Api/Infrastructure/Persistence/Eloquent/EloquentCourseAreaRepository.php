<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\CourseArea;
use App\CourseCategory;
use Lifecole\Api\Domain\Repository\CourseAreaRepository;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCourseAreaRepository extends EloquentRepository implements CourseAreaRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?CourseArea
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
        return CourseArea::class;
    }
}
