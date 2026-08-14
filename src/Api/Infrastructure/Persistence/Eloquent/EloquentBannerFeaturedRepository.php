<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\BannerFeatured;
use App\Http\Resources\BannerFeaturedResources;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Mi-empresa\Api\Domain\Repository\BannerFeaturedRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentBannerFeaturedRepository extends EloquentRepository implements BannerFeaturedRepository
{
    public function getAll(\Mi-empresa\Api\Domain\DTO\BannerFeatured $bannerFeatured)
    {
        $filters = $bannerFeatured->toArray();
        return $this->model
            ->when(isset($filters['categories']), function ($query) use ($filters) {
                $query->where('category_id', $filters['categories']);
            })
            ->orderBy('order_banner')->get();
    }

    public function getCategories(): AnonymousResourceCollection
    {
        $model = $this->model->select('category_id')->groupBy('category_id')->get();
        return BannerFeaturedResources::collection($model);
    }

    protected function model(): string
    {
        return BannerFeatured::class;
    }
}
