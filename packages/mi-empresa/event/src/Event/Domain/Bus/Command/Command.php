<?php

namespace Mi-empresa\Event\Domain\Bus\Command;

use Mi-empresa\Event\Domain\Bus\Request;

abstract class Command extends Request
{
    public function requestType(): string
    {
        return 'command';
    }
}
