<?php

namespace Lifecole\Api\Application\BannerFeatured\GetBannerFeatured;

use Lifecole\Api\Domain\Repository\BannerFeaturedRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

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
