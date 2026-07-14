<?php

namespace Lifecole\Api\Application\FavoritesCourses\CreateFavoritesCourses;

use Lifecole\Api\Domain\Repository\FavoritesCoursesRepository;
use Lifecole\Event\Domain\Bus\Command\CommandHandler;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

class CreateFavoritesCoursesCommandHandler implements CommandHandler
{
    private FavoritesCoursesRepository $favoritesCoursesRepository;

    public function __construct(FavoritesCoursesRepository $favoritesCoursesRepository)
    {
        $this->favoritesCoursesRepository = $favoritesCoursesRepository;
    }

    public function __invoke(CreateFavoritesCoursesCommand $command): void
    {
        $this->favoritesCoursesRepository->createFavoritesCoursesByData(
            CourseId::create($command->courseId()),
            UserId::create($command->userId())
        );
    }
}
