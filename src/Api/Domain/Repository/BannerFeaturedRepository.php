<?php

namespace Lifecole\Api\Domain\Repository;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Lifecole\Api\Domain\DTO\BannerFeatured;

interface BannerFeaturedRepository
{
    public function getAll(BannerFeatured $bannerFeatured);

    public function getCategories(): AnonymousResourceCollection;
}
