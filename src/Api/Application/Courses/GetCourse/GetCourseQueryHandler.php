<?php

namespace Mi-empresa\Api\Application\Courses\GetCourse;

use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetCourseQueryHandler implements QueryHandler
{
    public function __construct(private CoursesRepository $coursesRepository)
    {
    }

    public function __invoke(GetCourseQuery $getCourseQuery)
    {
        $filters = [
            'courses.slug' => $getCourseQuery->slug(),
            'categories.slug' => $getCourseQuery->category(),
            'specialization.slug' => $getCourseQuery->specialization(),
            'visible' => $getCourseQuery->visible()
        ];

        return $this->coursesRepository->getCourseByArrayParameters($filters);
    }
}
