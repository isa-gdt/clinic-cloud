DOCKER_COMPOSE = docker compose
PHP = docker exec -it laravel-api php
.PHONY: tests
.PHONY: last-tweets

up:
	@$(DOCKER_COMPOSE) up -d

down:
	@$(DOCKER_COMPOSE) down

build:
	@$(DOCKER_COMPOSE) build

install:
	@$(PHP) composer install

tests:
	$(PHP) ./vendor/bin/phpunit ${args}

help:
	@echo "Available commands:"
	@echo "  make up           		- Start the containers with Docker"
	@echo "  make down         		- Stop the containers"
	@echo "  make build        		- Build the Docker image"
	@echo "  make install      		- Install dependencies with Composer"
	@echo "  make tests        		- Run tests"

