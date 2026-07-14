<?php

namespace Lifecole\Api\Application\CourseCategory\GetCourseCategory;

use App\CourseCategory;
use Lifecole\Api\Domain\Repository\CourseCategoryRepository;

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
