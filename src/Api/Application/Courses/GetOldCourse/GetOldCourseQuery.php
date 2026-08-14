<?php

namespace Mi-empresa\Api\Application\Courses\GetOldCourse;

use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetOldCourseQuery extends Query
{
    public function __construct(
        private string $slug,
        private string $old_category
    ) {
        parent::__construct();
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function oldCategory(): ?string
    {
        return $this->old_category;
    }
}
