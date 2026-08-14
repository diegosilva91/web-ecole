<?php

declare(strict_types=1);

namespace Mi-empresa\Event\Domain\Bus\Query;

use Mi-empresa\Event\Domain\Bus\Request;

class Query extends Request
{
    public function requestType(): string
    {
        return 'query';
    }
}
