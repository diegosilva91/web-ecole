<?php

namespace Lifecole\Api\Application\BannerFeatured\GetCategoriesBannerFeatured;

use Lifecole\Api\Domain\Repository\BannerFeaturedRepository;
use Lifecole\Event\Domain\Bus\Query\QueryHandler;

class GetCategoriesBannerFeaturedQueryHandler implements QueryHandler
{
    public function __construct(private BannerFeaturedRepository $bannerFeaturedRepository)
    {
    }

    public function __invoke(GetCategoriesBannerFeaturedQuery $getCategoriesBannerFeaturedQuery)
    {
        return $this->bannerFeaturedRepository->getCategories();
    }
}
