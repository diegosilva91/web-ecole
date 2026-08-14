<?php

namespace Mi-empresa\Api\Application\Courses\GetOldCourse;

use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetOldCourseQueryHandler implements QueryHandler
{
    public function __construct(private CoursesRepository $coursesRepository)
    {
    }

    public function __invoke(GetOldCourseQuery $getOldCourseQuery)
    {
        $filters = [
            'courses.slug' => $getOldCourseQuery->slug(),
            'old_categories.slug' => $getOldCourseQuery->oldCategory()
        ];

        return $this->coursesRepository->getCourseByOldArrayParameters($filters);
    }
}
