<?php

namespace Mi-empresa\Api\Domain\Repository;

use Mi-empresa\Api\Domain\DTO\CoursesSearch;

interface SearcherCoursesRepository
{
    public function search(CoursesSearch $coursesSearch);
}
