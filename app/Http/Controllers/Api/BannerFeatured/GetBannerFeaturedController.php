<?php

namespace App\Http\Controllers\Api\BannerFeatured;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lifecole\Api\Application\BannerFeatured\GetBannerFeatured\GetBannerFeaturedQuery;
use Lifecole\Api\Application\BannerFeatured\GetCategoriesBannerFeatured\GetCategoriesBannerFeaturedQuery;
use Lifecole\Api\Domain\Adapter\CdnAdapter;
use Lifecole\Api\Domain\DTO\BannerFeatured;
use Lifecole\Event\Domain\Bus\Query\QueryBus;

class GetBannerFeaturedController extends Controller
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function index(CdnAdapter $cdnAdapter, Request $request): JsonResponse
    {
        return response()->json([
            'url' => $cdnAdapter->base(),
            'bannerFeatured' => $this->queryBus->ask(new GetBannerFeaturedQuery(
                BannerFeatured::createFromRequest(
                    $request->get('category')
                )
            ))
        ]);
    }

    public function getCategories(): JsonResponse
    {
        return response()->json([
            'categories' => $this->queryBus->ask(new GetCategoriesBannerFeaturedQuery())
        ]);
    }
}
