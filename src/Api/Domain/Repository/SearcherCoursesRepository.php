<?php

namespace Lifecole\Api\Domain\Repository;

use Lifecole\Api\Domain\DTO\CoursesSearch;

interface SearcherCoursesRepository
{
    public function search(CoursesSearch $coursesSearch);
}
