web: vendor/bin/heroku-php-nginx -C doc/heroku/deploy/nginx.conf public/
worker: php artisan queue:restart && php artisan queue:work database --tries=3
