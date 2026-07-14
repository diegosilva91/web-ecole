<?php

namespace Lifecole\Api\Application\Tag\GetCoursesTag;

use Lifecole\Event\Domain\Bus\Query\Query;

class GetCoursesTagQuery extends Query
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
