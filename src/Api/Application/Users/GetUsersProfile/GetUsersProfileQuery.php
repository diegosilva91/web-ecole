<?php

namespace Lifecole\Api\Application\Users\GetUsersProfile;

use Lifecole\Event\Domain\Bus\Query\Query;
use Lifecole\Shared\Domain\ValueObject\UserId;

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
