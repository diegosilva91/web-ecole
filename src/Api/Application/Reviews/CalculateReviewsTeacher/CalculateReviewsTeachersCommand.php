<?php

namespace Lifecole\Api\Application\Reviews\CalculateReviewsTeacher;

use Lifecole\Event\Domain\Bus\Command\Command;
use Lifecole\Shared\Domain\ValueObject\UserId;

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
