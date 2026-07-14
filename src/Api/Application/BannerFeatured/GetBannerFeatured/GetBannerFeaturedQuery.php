<?php

namespace Lifecole\Api\Application\BannerFeatured\GetBannerFeatured;

use Lifecole\Api\Domain\DTO\BannerFeatured;
use Lifecole\Event\Domain\Bus\Query\Query;

class GetBannerFeaturedQuery extends Query
{
    public function __construct(private BannerFeatured $bannerFeatured)
    {
        parent::__construct();
    }

    public function bannerFeatured(): BannerFeatured
    {
        return $this->bannerFeatured;
    }
}
