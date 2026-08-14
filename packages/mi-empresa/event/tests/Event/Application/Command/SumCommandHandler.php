<?php

declare(strict_types=1);

namespace Mi-empresa\Tests\Event\Application\Command;

use Mi-empresa\Event\Domain\Bus\Command\CommandHandler;

final class SumCommandHandler implements CommandHandler
{
    public function __invoke(SumCommand $command): void
    {
        $nothing = array_sum($command->numbers());
    }
}
