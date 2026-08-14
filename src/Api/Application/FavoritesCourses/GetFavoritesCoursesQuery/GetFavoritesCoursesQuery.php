<?php

namespace Mi-empresa\Api\Application\FavoritesCourses\GetFavoritesCoursesQuery;

use Mi-empresa\Event\Domain\Bus\Query\Query;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class GetFavoritesCoursesQuery extends Query
{
    public function __construct(private CourseId $courseId, private UserId $userId)
    {
        parent::__construct();
    }

    public function courseId(): CourseId
    {
        return $this->courseId;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

}
