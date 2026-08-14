<?php

namespace Mi-empresa\Api\Application\Reviews\CalculateReviewsCourse;

use Mi-empresa\Event\Domain\Bus\Command\Command;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;

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
