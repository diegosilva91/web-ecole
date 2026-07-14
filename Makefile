
composer-env-file:
	@if [ ! -f .env.local ]; then echo '' > .env.local; fi

.PHONY: test-unit
test-unit: composer-env-file
	docker exec docker_lifecole_php_1 php /var/www/html/composer.phar run-unit-tests

.PHONY: test-style
test-style: composer-env-file
	docker exec docker_lifecole_php_1 php /var/www/html/composer.phar check-style
