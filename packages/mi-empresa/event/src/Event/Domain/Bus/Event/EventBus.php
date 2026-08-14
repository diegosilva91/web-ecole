<?php

declare(strict_types=1);

namespace Mi-empresa\Event\Domain\Bus\Event;

interface EventBus
{
    public function notify(Event $event): void;
}
