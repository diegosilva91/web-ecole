<?php

namespace Mi-empresa\Api\Domain\Repository;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Mi-empresa\Api\Domain\DTO\BannerFeatured;

interface BannerFeaturedRepository
{
    public function getAll(BannerFeatured $bannerFeatured);

    public function getCategories(): AnonymousResourceCollection;
}
