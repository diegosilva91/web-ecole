
[![Lifecole Web Build Workflow](https://github.com/lifecole/web/actions/workflows/build.yaml/badge.svg?branch=main)](https://github.com/lifecole/web/actions/workflows/build.yaml)

[![Deploy Manual Workflow](https://github.com/lifecole/web/actions/workflows/deploy.yaml/badge.svg?branch=main)](https://github.com/lifecole/web/actions/workflows/deploy.yaml)

## Lifecole.com

docker exec -it docker_lifecole_php_1 php /var/www/html/composer.phar install --no-cache

- Contents and share assets for project: https://drive.google.com/drive/folders/1UGBecfzCXlKcdNXFDfQh4gcrv8F560gD?usp=sharing

## S3
FILESYSTEM_DRIVER = s3
composer require league/flysystem-aws-s3-v3
heroku run 'composer require league/flysystem-aws-s3-v3' --size standard-2x --ap devlifecole

https://devcenter.heroku.com/articles/cloudcube

COMPOSER_MEMORY_LIMIT=-1 composer update
