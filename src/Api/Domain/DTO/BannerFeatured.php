<?php

namespace Mi-empresa\Api\Domain\DTO;

class BannerFeatured
{
    private function __construct(private ?int $category)
    {
    }

    public function toArray()
    {
        return [
            'categories' => $this->category()
        ];
    }

    public static function createFromRequest(?int $category): self
    {
        return new self($category);
    }

    public function category(): ?int
    {
        return $this->category;
    }
}
