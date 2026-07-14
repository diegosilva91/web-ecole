<?php

declare(strict_types=1);

namespace Lifecole\Tests\Event\Application\Command;

use Lifecole\Event\Domain\Bus\Command\CommandHandler;

final class SumCommandHandler implements CommandHandler
{
    public function __invoke(SumCommand $command): void
    {
        $nothing = array_sum($command->numbers());
    }
}
