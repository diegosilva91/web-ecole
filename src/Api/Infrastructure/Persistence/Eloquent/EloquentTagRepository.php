<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\CourseSpecialization;
use App\Tag;
use Lifecole\Api\Domain\Repository\CourseSpecializationRepository;
use Lifecole\Api\Domain\Repository\TagRepository;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentTagRepository extends EloquentRepository implements TagRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?Tag
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
        return Tag::class;
    }
}
