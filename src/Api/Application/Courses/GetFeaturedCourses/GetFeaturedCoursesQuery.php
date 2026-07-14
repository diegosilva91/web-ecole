<?php

namespace Lifecole\Api\Application\Courses\GetFeaturedCourses;

use Lifecole\Event\Domain\Bus\Query\Query;
use Lifecole\Shared\Domain\ValueObject\UserId;

class GetFeaturedCoursesQuery extends Query
{
    private int $limit;
    private ?UserId $userId;

    public function __construct(int $limit, UserId $userId = null, private ?array $filters = null)
    {
        parent::__construct();

        $this->limit = $limit;
        $this->userId = $userId;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function userId(): ?UserId
    {
        return $this->userId;
    }

    public function filters(): ?array
    {
        return $this->filters;
    }
}
