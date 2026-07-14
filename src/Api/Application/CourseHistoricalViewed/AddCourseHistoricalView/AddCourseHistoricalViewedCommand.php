<?php

namespace Lifecole\Api\Application\CourseHistoricalViewed\AddCourseHistoricalView;

use Lifecole\Event\Domain\Bus\Command\Command;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

class AddCourseHistoricalViewedCommand extends Command
{
    public function __construct(private UserId $userId, private CourseId $courseId)
    {
        parent::__construct();
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function courseId(): CourseId
    {
        return $this->courseId;
    }
}
