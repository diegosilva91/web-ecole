<?php

declare(strict_types=1);

namespace Lifecole\Event\Domain\Bus\Query;

use Lifecole\Event\Domain\Bus\Request;

class Query extends Request
{
    public function requestType(): string
    {
        return 'query';
    }
}
