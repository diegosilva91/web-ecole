
[![Mi-empresa Web Build Workflow](https://github.com/mi-empresa/web/actions/workflows/build.yaml/badge.svg?branch=main)](https://github.com/mi-empresa/web/actions/workflows/build.yaml)

[![Deploy Manual Workflow](https://github.com/mi-empresa/web/actions/workflows/deploy.yaml/badge.svg?branch=main)](https://github.com/mi-empresa/web/actions/workflows/deploy.yaml)

## Mi-empresa.com

docker exec -it docker_mi-empresa_php_1 php /var/www/html/composer.phar install --no-cache

- Contents and share assets for project: https://drive.google.com/drive/folders/1UGBecfzCXlKcdNXFDfQh4gcrv8F560gD?usp=sharing

## S3
FILESYSTEM_DRIVER = s3
composer require league/flysystem-aws-s3-v3
heroku run 'composer require league/flysystem-aws-s3-v3' --size standard-2x --ap devmi-empresa

https://devcenter.heroku.com/articles/cloudcube

COMPOSER_MEMORY_LIMIT=-1 composer update
