<?php

declare(strict_types=1);

namespace Lifecole\Tests\Event\Application\Command;

use Lifecole\Event\Domain\Bus\Command\Command;

final class SumCommand extends Command
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
