up:
	docker-compose up -d

build:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	docker-compose down
	docker-compose up -d --build

init:
	cp .env.example .env
	docker-compose up -d --build
	docker-compose exec front touch .env
	docker-compose exec app composer install
	docker-compose exec app cp .env.example .env
	docker-compose exec app php artisan key:generate
	sleep 10
	docker-compose exec app php artisan migrate:fresh --seed
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan route:cache
	docker-compose down
dev:
	docker-compose up
