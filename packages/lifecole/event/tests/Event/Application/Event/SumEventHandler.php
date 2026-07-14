<?php

declare(strict_types=1);

namespace Lifecole\Tests\Event\Application\Event;

use Lifecole\Event\Domain\Bus\Event\EventHandler;

final class SumEventHandler implements EventHandler
{
    public function __invoke(SumEvent $Event): void
    {
        $nothing = array_sum($Event->numbers());
    }
}
