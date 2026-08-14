<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\FavouritesCourses;
use Mi-empresa\Api\Domain\Repository\FavoritesCoursesRepository;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentFavoritesCoursesRepository extends EloquentRepository implements FavoritesCoursesRepository
{
    public function createFavoritesCoursesByData(CourseId $courseId, UserId $userId): void
    {
        $model = new $this->model();
        $model->course_id = $courseId->value();
        $model->user_id = $userId->value();
        $model->save();
    }

    public function getFavoriteCourseByParameters(?array $filters)
    {
        $model = $this->model->when(isset($filters), function ($query) use ($filters) {
            return $query->where($filters);
        });

        return optional($model)->first();
    }

    protected function model(): string
    {
        return FavouritesCourses::class;
    }
}
