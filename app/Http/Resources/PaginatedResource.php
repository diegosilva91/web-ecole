<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginatedResource extends JsonResource
{
    public function __construct($resource, private $resourceCollection, private int $page = 1, private $total = 6)
    {
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        $page = $this->page ?? 1;
        $offset = ($page - 1) * $this->total;
        $items = array_slice($this->resource->toArray(), $offset, $this->total);

        $dataResourced = $this->resourceCollection::collection($this->resource);
        $i = array_slice($dataResourced->collection->toArray(), $offset, $this->total);
        return new LengthAwarePaginator(
            $i, //items
            count($this->resource->toArray()), //total
            $this->total,
            $page
        );
    }
}
