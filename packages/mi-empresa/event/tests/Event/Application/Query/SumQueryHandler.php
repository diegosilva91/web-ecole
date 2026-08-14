<?php

declare(strict_types=1);

namespace Mi-empresa\Tests\Event\Application\Query;

use Mi-empresa\Event\Domain\Bus\Query\QueryHandler;

final class SumQueryHandler implements QueryHandler
{
    public function __invoke(SumQuery $query): int
    {
        return array_sum($query->numbers());
    }
}
