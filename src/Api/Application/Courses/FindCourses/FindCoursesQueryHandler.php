<?php

namespace Mi-empresa\Api\Application\Courses\FindCourses;

use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class FindCoursesQueryHandler implements QueryHandler
{
    private CoursesRepository $coursesRepository;

    public function __construct(CoursesRepository $coursesRepository)
    {
        $this->coursesRepository = $coursesRepository;
    }

    public function __invoke(FindCoursesQuery $findCoursesQuery): object
    {
        return $this->coursesRepository->find($findCoursesQuery);
    }
}
