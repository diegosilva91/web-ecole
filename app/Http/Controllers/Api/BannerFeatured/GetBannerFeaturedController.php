<?php

namespace App\Http\Controllers\Api\BannerFeatured;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mi-empresa\Api\Application\BannerFeatured\GetBannerFeatured\GetBannerFeaturedQuery;
use Mi-empresa\Api\Application\BannerFeatured\GetCategoriesBannerFeatured\GetCategoriesBannerFeaturedQuery;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Mi-empresa\Api\Domain\DTO\BannerFeatured;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;

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
