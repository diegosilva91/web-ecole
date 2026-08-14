<?php

declare(strict_types=1);

namespace Mi-empresa\Event\Domain\Purchase;

use Mi-empresa\Event\Domain\Bus\Event\Event;

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
