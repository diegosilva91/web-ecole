<?php

namespace Mi-empresa\Api\Domain\Repository;

use App\CourseSpecialization;

interface CourseSpecializationRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?CourseSpecialization;
}
