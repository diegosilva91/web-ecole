<?php

namespace App\Http\Controllers\Test;

use Lifecole\Api\Application\Menu\GetElementsFromMenuQuery;
use Lifecole\Event\Domain\Bus\Query\QueryBus;

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
