<?php

namespace Lifecole\Api\Domain\Repository;

use App\CourseArea;

interface CourseAreaRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?CourseArea;
}