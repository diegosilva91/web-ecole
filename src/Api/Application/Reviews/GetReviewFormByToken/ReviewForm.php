<?php

namespace Mi-empresa\Api\Application\Reviews\GetReviewFormByToken;

use Illuminate\Database\Eloquent\Collection;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class ReviewForm
{
    private UserId $userId;
    private CourseId $courseId;
    private string $title;
    private Collection $courseUsers;

    public function __construct(CourseId $courseId, UserId $userId, string $title, Collection $courseUsers)
    {
        $this->userId = $userId;
        $this->courseId = $courseId;
        $this->title = $title;
        $this->courseUsers = $courseUsers;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function courseId(): CourseId
    {
        return $this->courseId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function coursesUsers(): Collection
    {
        return $this->courseUsers;
    }
}
