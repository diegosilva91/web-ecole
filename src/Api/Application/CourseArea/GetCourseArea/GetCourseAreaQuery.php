<?php

namespace Mi-empresa\Api\Application\CourseArea\GetCourseArea;

use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetCourseAreaQuery extends Query
{
    public function __construct(private ?array $selectColumns, private ?array $filtersColumns)
    {
        parent::__construct();
    }

    public function selectColumns(): ?array
    {
        return $this->selectColumns;
    }

    public function filtersColumns(): ?array
    {
        return $this->filtersColumns;
    }
}
