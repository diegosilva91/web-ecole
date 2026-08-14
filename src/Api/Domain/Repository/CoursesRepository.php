<?php

namespace Mi-empresa\Api\Domain\Repository;

use Mi-empresa\Api\Application\Courses\FindCourses\FindCoursesQuery;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

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
