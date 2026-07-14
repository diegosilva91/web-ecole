<?php

declare(strict_types=1);

namespace Lifecole\Event\Domain\Bus\Event;

interface EventBus
{
    public function notify(Event $event): void;
}
