<?php

namespace Lifecole\Api\Application\Courses\FindCourses;

use Lifecole\Event\Domain\Bus\Query\Query;

class FindCoursesQuery extends Query
{
    private array $filters;
    private int $limit;
    private bool $activeCourses = true;
    private int $minCourses = 0;

    public function __construct(array $filters, int $limit, bool $activeCourses = true, int $minCourses = 0)
    {
        parent::__construct();

        $this->filters = $filters;
        $this->limit = $limit;
        $this->activeCourses = $activeCourses;
        $this->minCourses = $minCourses;
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function activeCourses(): bool
    {
        return $this->activeCourses;
    }

    public function minCourses(): int
    {
        return $this->minCourses;
    }

    public function hasMinCourses(): bool
    {
        return ($this->minCourses > 0);
    }
}
