<?php

namespace Lifecole\Api\Application\Courses\GetFeaturedCourses;

use Lifecole\Api\Domain\Repository\CoursesRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

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
