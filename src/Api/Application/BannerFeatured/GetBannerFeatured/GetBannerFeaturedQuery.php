<?php

namespace Mi-empresa\Api\Application\BannerFeatured\GetBannerFeatured;

use Mi-empresa\Api\Domain\DTO\BannerFeatured;
use Mi-empresa\Event\Domain\Bus\Query\Query;

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
