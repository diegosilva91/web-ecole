<?php

namespace Lifecole\Api\Application\Courses\CoursesSearchTag;

use Lifecole\Api\Domain\DTO\CoursesSearch;
use Lifecole\Event\Domain\Bus\Query\Query;

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
