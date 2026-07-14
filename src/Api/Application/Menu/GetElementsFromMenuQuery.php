<?php

namespace Lifecole\Api\Application\Menu;

use Lifecole\Api\Domain\DTO\CoursesSearch;
use Lifecole\Api\Domain\DTO\MenuTreeSelector;
use Lifecole\Event\Domain\Bus\Query\Query;

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
