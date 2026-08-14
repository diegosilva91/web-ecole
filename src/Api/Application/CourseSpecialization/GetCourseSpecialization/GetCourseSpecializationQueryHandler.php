<?php

namespace Mi-empresa\Api\Application\CourseSpecialization\GetCourseSpecialization;

use App\CourseSpecialization;
use Mi-empresa\Api\Domain\Repository\CourseSpecializationRepository;

class GetCourseSpecializationQueryHandler
{
    public function __construct(private CourseSpecializationRepository $courseSpecializationRepository)
    {
    }

    public function __invoke(GetCourseSpecializationQuery $getCourseSpecializationQuery): ?array
    {
        $model = $this->courseSpecializationRepository->findByParameters(
            $getCourseSpecializationQuery->selectColumns(),
            $getCourseSpecializationQuery->filtersColumns()
        );

        if ($model instanceof CourseSpecialization) {
            return $model->toArray();
        }

        return [];
    }
}
