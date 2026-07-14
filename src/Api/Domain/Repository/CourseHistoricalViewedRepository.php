<?php

namespace Lifecole\Api\Domain\Repository;

interface CourseHistoricalViewedRepository
{
    public function firstOrAdd($dataFind);
    public function updateOrCreate($dataFind,$dataUpdate);
}