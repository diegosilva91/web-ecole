<?php

namespace Lifecole\Api\Domain\Repository;

use App\CourseSpecialization;
use App\Tag;

interface TagRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?Tag;
}