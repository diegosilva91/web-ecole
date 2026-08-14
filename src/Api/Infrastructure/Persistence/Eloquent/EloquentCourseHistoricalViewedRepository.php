<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\CoursesHistoricalViewed;
use Mi-empresa\Api\Domain\Repository\CourseHistoricalViewedRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCourseHistoricalViewedRepository extends EloquentRepository implements CourseHistoricalViewedRepository
{
    public function firstOrAdd($dataFind)
    {
        $model = new $this->model();
        return $model->firstOrCreate($dataFind);
    }

    public function updateOrCreate($dataFind,$dataUpdate)
    {
        $model = new $this->model();
        $model->updateOrCreate($dataFind, $dataUpdate);
    }

    protected function model(): string
    {
        return CoursesHistoricalViewed::class;
    }
}