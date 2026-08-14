<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\CourseReviews;
use Illuminate\Contracts\Support\Arrayable;
use Mi-empresa\Api\Domain\Repository\CourseReviewsRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentCourseReviewsRepository extends EloquentRepository implements CourseReviewsRepository
{
    public function retrieveAll(): object
    {
        $this->model = $this->model->all();
        return $this->model;
    }

    public function updateOrCreate(array $dataFind, array $dataUpdate): void
    {
        $model = new $this->model();
        $model->updateOrCreate($dataFind, $dataUpdate);
    }

    public function getByColumn(string $columnName, string $columnValue, string $operator = '='): object
    {
        if (!is_array($columnValue) && !$columnValue instanceof Arrayable) {
            $this->model = $this->model->where($columnName, $operator, $columnValue);
            return $this;
        }
        return $this;
    }

    public function retrieveFromQuery()
    {
        $this->model = $this->model->get();
        return $this->model;
    }

    public function countTotal()
    {
        $getModel = $this->model->get();
        return $getModel->count();
    }

    public function getAvgColumn(string $columnName)
    {
        return $this->model->avg($columnName);
    }

    protected function model(): string
    {
        return CourseReviews::class;
    }
}
