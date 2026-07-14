<?php

namespace Lifecole\Api\Application\Reviews\CalculateReviewsCourse;

use Lifecole\Event\Domain\Bus\Command\Command;
use Lifecole\Shared\Domain\ValueObject\CourseId;

class CalculateReviewsCourseCommand extends Command
{
    public function __construct(private CourseId $courseId)
    {
        parent::__construct();
    }

    public function courseId(): CourseId
    {
        return $this->courseId;
    }
}
