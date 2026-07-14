<?php

declare(strict_types=1);

namespace Lifecole\Event\Domain\Purchase;

use Lifecole\Event\Domain\Bus\Event\Event;

class PurchaseWasCompleted extends Event
{
    public function __construct(private int $id)
    {
        parent::__construct();
    }

    public function id(): int
    {
        return $this->id;
    }
}
