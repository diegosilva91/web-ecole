<?php

namespace Mi-empresa\Api\Application\Menu;

use Mi-empresa\Api\Domain\DTO\CoursesSearch;
use Mi-empresa\Api\Domain\DTO\MenuTreeSelector;
use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetElementsFromMenuQuery extends Query
{
    public function __construct(private MenuTreeSelector $menuTreeSelector, private ?CoursesSearch $coursesSearch)
    {
        parent::__construct();
    }

    public function selector()
    {
        return $this->menuTreeSelector->needs();
    }

    public function coursesSearch(): ?CoursesSearch
    {
        return $this->coursesSearch;
    }

}
