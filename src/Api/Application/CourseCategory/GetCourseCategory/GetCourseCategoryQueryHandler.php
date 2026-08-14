<?php

namespace Mi-empresa\Api\Application\CourseCategory\GetCourseCategory;

use App\CourseCategory;
use Mi-empresa\Api\Domain\Repository\CourseCategoryRepository;

class GetCourseCategoryQueryHandler
{
    public function __construct(private CourseCategoryRepository $courseCategoryRepository)
    {
    }

    public function __invoke(GetCourseCategoryQuery $getCourseCategoryQuery): ?array
    {
        $model = $this->courseCategoryRepository->findByParameters(
            $getCourseCategoryQuery->selectColumns(),
            $getCourseCategoryQuery->filtersColumns()
        );

        if ($model instanceof CourseCategory) {
            return $model->toArray();
        }

        return [];
    }
}
