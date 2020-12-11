start:
	php artisan serve --host 0.0.0.0 & npm run watch
setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:gen --ansi
	touch database/database.sqlite
	make migrate
	make seed
	npm install
watch:
	npm run watch

migrate:
	php artisan migrate
	
seed:
	php artisan db:seed

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

deploy:
	git push heroku

lint:
	composer exec phpcs -v

lint-fix:
	composer exec phpcbf

compose:
	docker-compose up

compose-test:
	docker-compose run web make test

compose-bash:
	docker-compose run web bash

compose-setup: compose-build
	docker-compose run web make setup

compose-build:
	docker-compose build

compose-db:
	docker-compose exec db psql -U postgres

compose-down:
	docker-compose down -v

test-coverage:
	composer test -- --coverage-clover build/logs/clover.xml