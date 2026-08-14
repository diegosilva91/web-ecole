<?php

namespace Mi-empresa\Api\Domain\Repository;

interface CourseHistoricalViewedRepository
{
    public function firstOrAdd($dataFind);
    public function updateOrCreate($dataFind,$dataUpdate);
}