<?php

declare(strict_types=1);

namespace Lifecole\Api\Domain\Repository;

use Lifecole\Api\Domain\DTO\TopBannerHome;

interface HomeRepository
{
    public function getTopBannerHome(): TopBannerHome;
}
