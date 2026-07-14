<?php

namespace Lifecole\Api\Domain\Repository;

interface CourseReviewsRepository
{
    public function retrieveAll(): object;

    public function updateOrCreate(array $dataFind, array $dataUpdate): void;

    public function getByColumn(string $columnName, string $columnValue, string $operator = '='): object;

    public function getAvgColumn(string $columnName);

    public function countTotal();

    public function retrieveFromQuery();
}
