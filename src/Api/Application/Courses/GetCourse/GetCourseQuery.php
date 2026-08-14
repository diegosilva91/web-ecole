<?php

namespace Mi-empresa\Api\Application\Courses\GetCourse;

use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetCourseQuery extends Query
{
    public function __construct(
        private string $specialization,
        private string $category,
        private string $slug,
        private bool $visible = true
    ) {
        parent::__construct();
    }

    public function specialization(): string
    {
        return $this->specialization;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function visible(): bool
    {
        return $this->visible;
    }
}
