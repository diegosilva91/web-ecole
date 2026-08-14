<?php

declare(strict_types=1);

namespace Mi-empresa\Api\Domain\Repository;

use Mi-empresa\Api\Domain\DTO\TopBannerHome;

interface HomeRepository
{
    public function getTopBannerHome(): TopBannerHome;
}
