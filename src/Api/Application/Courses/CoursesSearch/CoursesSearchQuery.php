<?php

namespace Mi-empresa\Api\Application\Courses\CoursesSearch;

use Mi-empresa\Api\Domain\DTO\CoursesSearch;
use Mi-empresa\Event\Domain\Bus\Query\Query;

class CoursesSearchQuery extends Query
{
    public function __construct(private CoursesSearch $coursesSearch)
    {
        parent::__construct();
    }

    public function coursesSearch(): CoursesSearch
    {
        return $this->coursesSearch;
    }
}
