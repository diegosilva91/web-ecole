<?php

namespace Mi-empresa\Api\Application\Reviews\CalculateReviewsTeacher;

use Mi-empresa\Event\Domain\Bus\Command\Command;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class CalculateReviewsTeachersCommand extends Command
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
