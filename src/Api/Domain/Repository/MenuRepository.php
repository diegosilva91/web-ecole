<?php

namespace Mi-empresa\Api\Domain\Repository;

use Mi-empresa\Api\Domain\DTO\CoursesSearch;

interface MenuRepository
{
    public function getElementsFromMenu(): array;

    public function getTreeElementsIntensives(): array;

    public function getTreeElementsTrajectories(): array;

    public function getTitlesFromSlugsMenu(CoursesSearch $coursesSearch, array $responseFilter): array;

}
