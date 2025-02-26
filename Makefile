DOCKER_COMPOSE = docker compose
DOCKER_EXEC = docker exec -it laravel-api
.PHONY: tests

up:
	@$(DOCKER_COMPOSE) up -d

down:
	@$(DOCKER_COMPOSE) down

build:
	@$(DOCKER_COMPOSE) build

install:
	@$(DOCKER_EXEC) composer install

tests:
	$(DOCKER_EXEC) php ./vendor/bin/phpunit ${args}

migrate:
	$(DOCKER_EXEC) php artisan migrate

seed:
	$(DOCKER_EXEC) php artisan db:seed --class=UserSeeder

db-dump:
	@$(DOCKER_COMPOSE) exec db mysql -u laravel -psecret $laravel < database/database.sql


help:
	@echo "Available commands:"
	@echo "  make up           		- Start the containers with Docker"
	@echo "  make down         		- Stop the containers"
	@echo "  make build        		- Build the Docker image"
	@echo "  make install      		- Install dependencies with Composer"
	@echo "  make tests        		- Run tests"
	@echo "  make migrate        	- Run laravel migrations and seed database"
	@echo "  make db-dump           - Run database dump"

