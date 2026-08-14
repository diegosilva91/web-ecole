<?php

namespace Mi-empresa\Api\Application\Courses\CoursesSearch;

use Mi-empresa\Api\Domain\Repository\SearcherCoursesRepository;

class CoursesSearchQueryHandler
{
    public function __construct(private SearcherCoursesRepository $searcherCoursesRepository)
    {
    }

    public function __invoke(CoursesSearchQuery $coursesSearchQuery)
    {
        return $this->searcherCoursesRepository->search($coursesSearchQuery->coursesSearch());
    }
}
