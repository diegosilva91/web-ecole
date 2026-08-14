<?php

return [
    'feeds' => [
        'main' => [
            /*
             * Here you can specify which class and method will return
             * the items that should appear in the feed. For example:
             * 'App\Model@getAllFeedItems'
             *
             * You can also pass an argument to that method:
             * ['App\Model@getAllFeedItems', 'argument']
             */
            'items' => 'App\Course@getFeedItems',

            /*
             * The feed will be available on this url.
             */
            'url' => '/courses.rss',

            'title' => 'Cursos de Mi-empresa',
            'description' => 'Marketplace de cursos extraescolares online con profesores en vivo: Refuerzo de Matemáticas, Física, Filosofía; Iniciación a la Programación y Robótica, Música, Idiomas, Dibujo, Escritura y mucho más.',
            'language' => 'es-ES',

            /*
             * The view that will render the feed.
             */
            'view' => 'feed::rss',

            /*
             * The type to be used in the <link> tag
             */
            'type' => 'application/atom+xml',
        ],
    ],
];
