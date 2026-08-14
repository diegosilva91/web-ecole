<?php

namespace Mi-empresa\Api\Domain\Repository;

use App\CourseCategory;

interface CourseCategoryRepository
{
    public function findByParameters(?array $arguments_get, ?array $filtersColumns): ?CourseCategory;
}