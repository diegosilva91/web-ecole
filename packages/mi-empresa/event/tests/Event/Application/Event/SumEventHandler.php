<?php

declare(strict_types=1);

namespace Mi-empresa\Tests\Event\Application\Event;

use Mi-empresa\Event\Domain\Bus\Event\EventHandler;

final class SumEventHandler implements EventHandler
{
    public function __invoke(SumEvent $Event): void
    {
        $nothing = array_sum($Event->numbers());
    }
}
