up:
	@docker compose up -d

up-recreate:
	@docker compose up --force-recreate -d

down:
	@docker compose down

destroy:
	@docker compose down --rmi all --volumes --remove-orphans

shell:
	@docker compose exec -it -u www-data web /bin/bash

shell-root:
	@docker compose exec -it web /bin/bash

tinker:
	@docker compose exec -it web php artisan tinker

tail:
	@docker compose exec -it web tail -f storage/logs/laravel.log

test:
	@docker compose exec -it -u www-data web php artisan test --coverage

phpcs:
	@docker compose exec -it -u www-data web ./vendor/bin/phpcs

phpcbf:
	@docker compose exec -it -u www-data web ./vendor/bin/phpcbf

composer-install:
	@docker compose exec -it -u www-data web composer install

composer-update:
	@docker compose exec -it -u www-data web composer update

npm-install:
	@docker compose exec -it -u www-data web npm install

npm-dev:
	@docker compose exec -it -u www-data web npm run dev

npm-build:
	@docker compose exec -it -u www-data web npm run build
