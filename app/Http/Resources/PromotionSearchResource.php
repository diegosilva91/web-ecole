<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionSearchResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'start_at' => $this->start_at,
            'end_at' => $this->end_at
        ];
    }
}
