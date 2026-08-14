<?php

namespace Mi-empresa\Api\Application\FavoritesCourses\CreateFavoritesCourses;

use Mi-empresa\Api\Domain\Repository\FavoritesCoursesRepository;
use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

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
