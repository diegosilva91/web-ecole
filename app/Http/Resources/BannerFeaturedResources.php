<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerFeaturedResources extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        $resourceArray = $this->resource;
        return [
            'category_id' => $resourceArray->category_id,
            'category' => optional($resourceArray)->getDescription(),
        ];
    }
}
