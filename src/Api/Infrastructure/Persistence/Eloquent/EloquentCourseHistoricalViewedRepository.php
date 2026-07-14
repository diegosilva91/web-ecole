<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\CoursesHistoricalViewed;
use Lifecole\Api\Domain\Repository\CourseHistoricalViewedRepository;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

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