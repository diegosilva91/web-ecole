<?php

namespace Mi-empresa\Api\Domain\Repository;

use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

interface FavoritesCoursesRepository
{
    public function createFavoritesCoursesByData(CourseId $courseId, UserId $userId): void;

    public function getFavoriteCourseByParameters(?array $filters);
}
