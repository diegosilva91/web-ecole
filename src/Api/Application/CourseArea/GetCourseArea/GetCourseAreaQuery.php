<?php

namespace Lifecole\Api\Application\CourseArea\GetCourseArea;

use Lifecole\Event\Domain\Bus\Query\Query;

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
