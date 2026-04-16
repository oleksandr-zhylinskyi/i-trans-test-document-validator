DC_EXEC = docker compose exec php-fpm

install:
	$(DC_EXEC) composer install

update:
	$(DC_EXEC) composer update

dump-autoload:
	$(DC_EXEC) composer dump-autoload

test:
	$(DC_EXEC) ./vendor/bin/phpunit
