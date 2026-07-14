<?php

namespace Lifecole\Api\Infrastructure\Redis;

use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Redis;
use Lifecole\Api\Domain\Adapter\CacheAdapter;

class RedisCacheAdapter implements CacheAdapter
{
    private Connection $redis;

    public function __construct()
    {
        $this->redis = Redis::connection('cache');
    }

    public function get(string $key): mixed
    {
        return $this->redis->get($key);
    }

    public function set(string $key, mixed $value, $expireTTL = null): void
    {
        $this->redis->set($key, $value);
        $this->redis->expire($key, $expireTTL);
    }
}
