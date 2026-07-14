<?php

namespace Lifecole\Api\Domain\Repository;

use Lifecole\Api\Application\Courses\FindCourses\FindCoursesQuery;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

interface CoursesRepository
{
    public function find(FindCoursesQuery $findCoursesQuery): object;

    public function featuredCourses(int $limit, UserId $userId = null, ?array $filters = null): object;

    public function withRelation(string $relation): object;

    public function findById(CourseId $courseId): object|null;

    public function updateById(CourseId $courseId, array $dataFill);

    public function getPromotionByUserIdThroughPromotionPurchase(UserId $user_id): object;

    public function getCourseByArrayParameters(array $parameters);

    public function getCourseByOldArrayParameters(array $parameters);

    public function getAll(array $relations, ?array $arguments_get, ?array $filters);
}
