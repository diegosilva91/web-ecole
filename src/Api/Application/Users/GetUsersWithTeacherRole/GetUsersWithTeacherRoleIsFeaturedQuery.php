<?php

namespace Mi-empresa\Api\Application\Users\GetUsersWithTeacherRole;

use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetUsersWithTeacherRoleIsFeaturedQuery extends Query
{
    public function __construct(private bool $is_featured)
    {
        parent::__construct();
    }

    public function isFeatured(): bool
    {
        return $this->is_featured;
    }
}
