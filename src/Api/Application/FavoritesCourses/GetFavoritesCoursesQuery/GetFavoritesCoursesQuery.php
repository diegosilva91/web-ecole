<?php

namespace Lifecole\Api\Application\FavoritesCourses\GetFavoritesCoursesQuery;

use Lifecole\Event\Domain\Bus\Query\Query;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

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
