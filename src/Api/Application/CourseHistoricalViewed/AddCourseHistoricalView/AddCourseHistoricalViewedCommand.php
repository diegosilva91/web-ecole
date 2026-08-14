<?php

namespace Mi-empresa\Api\Application\CourseHistoricalViewed\AddCourseHistoricalView;

use Mi-empresa\Event\Domain\Bus\Command\Command;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

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
