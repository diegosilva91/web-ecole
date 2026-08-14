<?php

declare(strict_types=1);

namespace Mi-empresa\Event\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query);//: ?Response;
}
