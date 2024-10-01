init: build up composer-install migrate permissions

build:
	docker-compose build

up:
	docker-compose up -d

composer-install:
	docker-compose exec app composer install

migrate:
	docker-compose exec app php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	docker-compose exec app php bin/console doctrine:fixtures:load --no-interaction

permissions:
	docker-compose exec app chown -R www-data:www-data var public

