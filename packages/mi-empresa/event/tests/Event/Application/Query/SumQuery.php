<?php

declare(strict_types=1);

namespace Mi-empresa\Tests\Event\Application\Query;

use Mi-empresa\Event\Domain\Bus\Query\Query;

final class SumQuery extends Query
{
    private array $numbers;

    public function __construct(int ...$numbers)
    {
        parent::__construct();

        $this->numbers = $numbers;
    }

    public function numbers(): array
    {
        return $this->numbers;
    }
}
