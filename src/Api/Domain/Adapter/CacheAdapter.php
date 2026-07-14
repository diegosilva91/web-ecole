<?php

namespace Lifecole\Api\Domain\Adapter;

interface CacheAdapter
{
    public function get(string $key): mixed;

    public function set(string $key, mixed $value, $expireTTL = null): void;
}
