<?php

namespace Lifecole\Api\Domain\Repository;

use Lifecole\Api\Domain\DTO\CoursesSearch;

interface MenuRepository
{
    public function getElementsFromMenu(): array;

    public function getTreeElementsIntensives(): array;

    public function getTreeElementsTrajectories(): array;

    public function getTitlesFromSlugsMenu(CoursesSearch $coursesSearch, array $responseFilter): array;

}
