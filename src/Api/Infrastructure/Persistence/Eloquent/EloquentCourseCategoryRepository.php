<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\CourseCategory;
use Mi-empresa\Api\Domain\Repository\CourseCategoryRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCourseCategoryRepository extends EloquentRepository implements CourseCategoryRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?CourseCategory
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
        return CourseCategory::class;
    }
}
