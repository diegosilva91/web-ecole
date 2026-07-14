<?php

namespace Lifecole\Api\Application\FavoritesCourses\CreateFavoritesCourses;

use Lifecole\Event\Domain\Bus\Command\Command;

class CreateFavoritesCoursesCommand extends Command
{
    private int $courseId;
    private int $userId;

    public function __construct(int $courseId, int $userId)
    {
        parent::__construct();

        $this->courseId = $courseId;
        $this->userId = $userId;
    }

    public function courseId(): int
    {
        return $this->courseId;
    }

    public function userId(): int
    {
        return $this->userId;
    }
}
