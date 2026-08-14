<?php

namespace Mi-empresa\Api\Application\Courses\CoursesSearchTag;

use Mi-empresa\Api\Domain\DTO\CoursesSearch;
use Mi-empresa\Event\Domain\Bus\Query\Query;

class CoursesSearchTagQuery extends Query
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
