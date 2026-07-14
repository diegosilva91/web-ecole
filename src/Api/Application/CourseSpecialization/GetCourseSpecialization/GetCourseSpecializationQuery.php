<?php

namespace Lifecole\Api\Application\CourseSpecialization\GetCourseSpecialization;

use Lifecole\Event\Domain\Bus\Query\Query;

class GetCourseSpecializationQuery extends Query
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
