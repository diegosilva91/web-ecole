<?php

namespace Lifecole\Event\Domain\Bus\Command;

use Lifecole\Event\Domain\Bus\Request;

abstract class Command extends Request
{
    public function requestType(): string
    {
        return 'command';
    }
}
