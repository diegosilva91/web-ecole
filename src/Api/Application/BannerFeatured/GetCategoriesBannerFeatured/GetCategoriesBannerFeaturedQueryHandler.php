<?php

namespace Mi-empresa\Api\Application\BannerFeatured\GetCategoriesBannerFeatured;

use Mi-empresa\Api\Domain\Repository\BannerFeaturedRepository;
use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

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
