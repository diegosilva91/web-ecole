<?php

namespace Lifecole\Api\Infrastructure\Persistence\Proxy;

use Lifecole\Api\Domain\Adapter\CacheAdapter;
use Lifecole\Api\Domain\DTO\CoursesSearch;
use Lifecole\Api\Domain\Repository\SearcherCoursesRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentSearcherCoursesRepository;

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

            $enabledCache = config('lifecole.cache')['enabled'];
            $enabledCacheSearcher = config('lifecole.cache')['searcher']['enabled'];
            $ttlCacheSearcher = config('lifecole.cache')['searcher']['ttl'];
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
