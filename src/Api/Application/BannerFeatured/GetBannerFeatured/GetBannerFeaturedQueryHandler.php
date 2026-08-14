<?php

namespace Mi-empresa\Api\Application\BannerFeatured\GetBannerFeatured;

use Mi-empresa\Api\Domain\Repository\BannerFeaturedRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

class GetBannerFeaturedQueryHandler implements QueryHandler
{
    public function __construct(private BannerFeaturedRepository $bannerFeaturedRepository)
    {
    }

    public function __invoke(GetBannerFeaturedQuery $getBannerFeaturedQuery)
    {
        return $this->bannerFeaturedRepository->getAll($getBannerFeaturedQuery->bannerFeatured());
    }
}
