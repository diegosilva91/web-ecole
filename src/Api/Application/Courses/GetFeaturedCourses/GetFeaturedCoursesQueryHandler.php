<?php

namespace Mi-empresa\Api\Application\Courses\GetFeaturedCourses;

use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetFeaturedCoursesQueryHandler implements QueryHandler
{
    private CoursesRepository $coursesRepository;

    public function __construct(CoursesRepository $coursesRepository)
    {
        $this->coursesRepository = $coursesRepository;
    }

    public function __invoke(GetFeaturedCoursesQuery $query): object
    {
        return $this->coursesRepository->featuredCourses(
            $query->limit(),
            $query->userId(),
            $query->filters()
        );
    }
}
