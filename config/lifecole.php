<?php

return [

    'cache' => [
        'enabled' => env('LIFECOLE_CACHE_ENABLED', true),

        'searcher' => [
            'enabled' => env('LIFECOLE_CACHE_SEARCHER_ENABLED', true),
            'ttl' => env('LIFECOLE_CACHE_SEARCHER_TTL', 300),
        ],
    ],

];
