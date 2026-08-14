<?php

namespace App\Http\Controllers\Test;

use Mi-empresa\Api\Application\Menu\GetElementsFromMenuQuery;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;

class TestMenuController
{
    private QueryBus $query;

    public function __construct(QueryBus $query)
    {
        $this->query = $query;
    }

    public function index()
    {
        dd($this->query->ask(new GetElementsFromMenuQuery()));
    }
}
