<?php

namespace Mi-empresa\Api\Application\FavoritesCourses\GetFavoritesCoursesQuery;

use Mi-empresa\Api\Domain\Repository\FavoritesCoursesRepository;

class GetFavoritesCoursesQueryHandler
{
    public function __construct(private FavoritesCoursesRepository $favoritesCoursesRepository)
    {
    }

    public function __invoke(GetFavoritesCoursesQuery $getFavoritesCourseQuery)
    {
        $filters = [
            'user_id' => $getFavoritesCourseQuery->userId()->value(),
            'course_id' => $getFavoritesCourseQuery->courseId()->value()
        ];
        return $this->favoritesCoursesRepository->getFavoriteCourseByParameters($filters);
    }
}
