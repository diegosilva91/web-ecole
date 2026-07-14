#FROM node:14-alpine as node
FROM node:14 as node

#RUN apk add binutils python g++ file
#RUN apk add make

ARG MIX_SENTRY_VUE_DNS
ARG MIX_STRIPE_KEY
ARG MIX_GTM_ID

ENV MIX_SENTRY_VUE_DNS=$MIX_SENTRY_VUE_DNS
ENV MIX_STRIPE_KEY=$MIX_STRIPE_KEY
ENV MIX_GTM_ID=$MIX_GTM_ID

WORKDIR /app

COPY package*.json ./

RUN npm install --no-audit --no-fund --no-optional

COPY public /app/public
COPY webpack* ./

COPY resources resources

RUN npm run production

FROM nginx:1.17-alpine as nginx

ENV APP_ENV prod

WORKDIR /app

COPY etc/artifact/nginx/performance/cache-file-descriptors.conf /etc/nginx/conf.d/
COPY etc/artifact/nginx/performance/cache_expiration.conf /etc/nginx/conf.d/
COPY etc/artifact/nginx/performance/compression.conf /etc/nginx/conf.d/
#COPY etc/artifact/nginx/performance/pre-compressed_content_brotli.conf /etc/nginx/conf.d/
COPY etc/artifact/nginx/performance/pre-compressed_content_gzip.conf /etc/nginx/conf.d/
COPY etc/artifact/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY --from=node /app/public /app/public

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
#COPY public /app/public
COPY resources /app/resources
COPY routes /app/routes
COPY src /app/src
COPY storage /app/storage
COPY tests /app/tests

COPY --from=node /app/public /app/public
COPY --from=node /app/node_modules /app/node_modules

RUN chown www-data:www-data /app/bootstrap/cache/ \
    && chown www-data:www-data /app/storage/logs/ \
    && chown www-data:www-data -R /app/storage/framework/

ENTRYPOINT ["./start.sh"]
