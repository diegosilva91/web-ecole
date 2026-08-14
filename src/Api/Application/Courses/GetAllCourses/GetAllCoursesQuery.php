<?php

namespace Mi-empresa\Api\Application\Courses\GetAllCourses;

use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetAllCoursesQuery extends Query
{
    public function __construct(private ?array $relations, private ?array $selectColumns, private ?array $filters)
    {
        parent::__construct();
    }

    public function filters(): ?array
    {
        return $this->filters;
    }
    public function relations(): ?array
    {
        return $this->relations;
    }

    public function selectColumns(): ?array
    {
        return $this->selectColumns;
    }
}
