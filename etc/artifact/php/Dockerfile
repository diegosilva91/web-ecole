FROM  546774249905.dkr.ecr.eu-west-1.amazonaws.com/lifecole/php-base:latest as php

ARG GITHUB_PERSONAL_TOKEN
ENV GITHUB_PERSONAL_TOKEN=${GITHUB_PERSONAL_TOKEN}

WORKDIR /app

ENV APP_ENV prod

COPY etc/artifact/php/php.ini /usr/local/etc/php/php.ini
COPY etc/artifact/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-docker.conf

COPY .env.testing .env
COPY /etc/artifact/start.sh .
COPY composer.json /app
COPY composer.lock /app

RUN composer config github-oauth.github.com ${GITHUB_PERSONAL_TOKEN}
RUN composer install --no-ansi --no-scripts --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

COPY artisan /app
COPY app /app/app
COPY bootstrap /app/bootstrap
COPY config /app/config
COPY database /app/database
COPY public /app/public
COPY resources /app/resources
COPY routes /app/routes
COPY src /app/src
#COPY storage /app/storage --> Crear todas las carpetas
COPY tests /app/tests

RUN mkdir storage \
    && mkdir storage/logs \
    && mkdir storage/framework \
    && mkdir storage/framework/sessions \
    && mkdir storage/framework/views \
    && mkdir storage/framework/cache

ENTRYPOINT ["./start.sh"]
