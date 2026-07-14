<?php

namespace Lifecole\Api\Application\Courses\GetOldCourse;

use Lifecole\Api\Domain\Repository\CoursesRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

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
