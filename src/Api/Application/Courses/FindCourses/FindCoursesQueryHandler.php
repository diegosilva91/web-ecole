<?php

namespace Lifecole\Api\Application\Courses\FindCourses;

use Lifecole\Api\Domain\Repository\CoursesRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

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
