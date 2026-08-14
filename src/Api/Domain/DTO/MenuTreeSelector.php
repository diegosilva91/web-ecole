<?php

namespace Mi-empresa\Api\Domain\DTO;

class MenuTreeSelector
{
    public const MENU_NEEDS = 0;
    public const TREE_NEEDS = 1;

    private function __construct(
        private $needs,
    ) {
    }

    public function needs()
    {
        return $this->needs;
    }
    public static function createFromRequest($needs): self
    {
        return new self($needs);
    }
}
