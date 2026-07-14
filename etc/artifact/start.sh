#!/usr/bin/env sh

set -ex

if [[ ${XDEBUG_ENABLED:-"false"} = "true" ]] ; then
    echo "WARNING: XDEBUG LOADED!"
    echo "         xdebug being loaded on production even if its not enabled at all degrades performance!!"
    docker-php-ext-enable xdebug

    cat << EOL > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
zend_extension=xdebug
xdebug.log_level=0
xdebug.start_with_request=yes
xdebug.client_host="${XDEBUG_CLIENT_HOST:-127.0.0.1}"
xdebug.client_port="${XDEBUG_CLIENT_PORT:-9003}"
xdebug.mode="${XDEBUG_mode:-debug}"
xdebug.max_nesting_level=250
xdebug.var_display_max_data=10000
xdebug.var_display_max_depth=20
EOL
    if [[ -n PHP_IDE_CONFIG ]] ; then
      cat << EOL >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
xdebug.idekey="${PHP_IDE_CONFIG}"
EOL
    fi

else
    echo "NOTE: You can enable manually xdebug by running 'docker-php-ext-enable xdebug'"
    echo "      and signaling apache with 'kill -SIGUSR1 <apache_pid>' to refresh the process."
    echo "      Also, you can start the container with XDEBUG_ENABLED=true to start it automatically"
fi

if [ "${START_DOCTRINE_MIGRATIONS:-"true"}" = "true" ] ; then
  php artisan migrate --force --no-interaction
fi

if [ -n "$(printf '%s' "$@")" ]; then
  exec "$@"
else
  exec php-fpm
fi
