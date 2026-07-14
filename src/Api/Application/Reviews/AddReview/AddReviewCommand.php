<?php

namespace Lifecole\Api\Application\Reviews\AddReview;

use Lifecole\Event\Domain\Bus\Command\Command;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

class AddReviewCommand extends Command
{
    public function __construct(
        private UserId $userId,
        private CourseId $courseId,
        private UserId $teacherId,
        private float $rating1,
        private float $rating2,
        private float $rating3,
        private float $rating4,
        private ?string $opinion
    ) {
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

    public function teacherId(): UserId
    {
        return $this->teacherId;
    }

    public function rating1(): float
    {
        return $this->rating1;
    }

    public function opinion(): ?string
    {
        return $this->opinion;
    }

    public function rating2(): float
    {
        return $this->rating2;
    }

    public function rating3(): float
    {
        return $this->rating3;
    }

    public function rating4(): float
    {
        return $this->rating4;
    }
}
