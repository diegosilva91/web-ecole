<?php

return [

    'cache' => [
        'enabled' => env('MI-EMPRESA_CACHE_ENABLED', true),

        'searcher' => [
            'enabled' => env('MI-EMPRESA_CACHE_SEARCHER_ENABLED', true),
            'ttl' => env('MI-EMPRESA_CACHE_SEARCHER_TTL', 300),
        ],
    ],

];
