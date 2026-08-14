<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Proxy;

use Mi-empresa\Api\Domain\Adapter\CacheAdapter;
use Mi-empresa\Api\Domain\DTO\CoursesSearch;
use Mi-empresa\Api\Domain\Repository\SearcherCoursesRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentSearcherCoursesRepository;

class ProxySearcherCoursesRepository implements SearcherCoursesRepository
{
    public function __construct(
        private EloquentSearcherCoursesRepository $eloquentSearcherCoursesRepository,
        private CacheAdapter $cacheAdapter
    )
    {
    }

    public function search(CoursesSearch $coursesSearch)
    {
        $key = $this->generateKey($coursesSearch);
        $value = $this->cacheAdapter->get($key);
        if ($value == null) {
            $value = $this->eloquentSearcherCoursesRepository->search($coursesSearch);

            $enabledCache = config('mi-empresa.cache')['enabled'];
            $enabledCacheSearcher = config('mi-empresa.cache')['searcher']['enabled'];
            $ttlCacheSearcher = config('mi-empresa.cache')['searcher']['ttl'];
            if ($enabledCache && $enabledCacheSearcher) {
                $this->cacheAdapter->set($key, serialize($value), $ttlCacheSearcher);
            }
        } else {
            $value = unserialize($value);
        }

        return $value;
    }

    private function generateKey(CoursesSearch $coursesSearch): string
    {
        return 'searcher_' . urlencode(json_encode($coursesSearch->toArray()));
    }
}
