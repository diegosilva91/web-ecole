<?php

namespace Mi-empresa\Api\Application\Users\GetUsersProfile;

use Mi-empresa\Event\Domain\Bus\Query\Query;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class GetUsersProfileQuery extends Query
{
    public function __construct(private UserId $userId)
    {
        parent::__construct();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }
}
