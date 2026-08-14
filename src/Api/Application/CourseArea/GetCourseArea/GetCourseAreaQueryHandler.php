<?php

namespace Mi-empresa\Api\Application\CourseArea\GetCourseArea;

use App\CourseArea;
use Mi-empresa\Api\Domain\Repository\CourseAreaRepository;

class GetCourseAreaQueryHandler
{
    public function __construct(private CourseAreaRepository $courseAreaRepository)
    {
    }

    public function __invoke(GetCourseAreaQuery $getCourseAreaQuery): ?array
    {
        $model = $this->courseAreaRepository->findByParameters(
            $getCourseAreaQuery->selectColumns(),
            $getCourseAreaQuery->filtersColumns()
        );

        if ($model instanceof CourseArea) {
            return $model->toArray();
        }

        return [];
    }
}
