<?php

namespace Mi-empresa\Api\Application\Courses\GetAllCourses;

use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetAllCoursesQueryHandler implements QueryHandler
{
    public function __construct(private CoursesRepository $coursesRepository)
    {
    }

    public function __invoke(GetAllCoursesQuery $getAllCoursesQuery)
    {
        return $this->coursesRepository->getAll(
            $getAllCoursesQuery->relations(),
            $getAllCoursesQuery->selectColumns(),
            $getAllCoursesQuery->filters()
        );
    }
}
