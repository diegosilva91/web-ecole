<?php

namespace Lifecole\Api\Domain\Repository;

use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

interface FavoritesCoursesRepository
{
    public function createFavoritesCoursesByData(CourseId $courseId, UserId $userId): void;

    public function getFavoriteCourseByParameters(?array $filters);
}
