# Global

image_name = charon-Charon-1


# Check Os
ifdef OS # Windown
	RM = del /Q
	RMDIR = rmdir /q /s
	COPY = copy

else # Linux, Unix, MacOs
	RM = rm -rf
	RMDIR = rm -rf
	COPY =  cp -r

# Get shell
# UNAME_S := $(shell uname -s)
endif

# For normal

setup:
	@make env
	@make generate-key

env:
	$(COPY) .env.example .env

generate-key:
	php artisan key:generate

data:
	@make migrate
	@make seed

migrate:
	php artisan migrate

seed:
	php artisan db:seed

up:
	php artisan serve

cache:
	php artisan config:cache


# For docker

docker-setup:
	@make docker-env
	@make docker-generate-key
	@make docker-up

composer-install:
	docker exec -it $(image_name) composer install --no-interaction

docker-env:
	$(COPY) .env.example .env

docker-generate-key:
	docker exec $(image_name) bash -c "php artisan key:generate"

docker-data:
	@make docker-migrate
	@make docker-seed

docker-migrate:
	docker exec $(image_name) bash -c "php artisan migrate"

docker-seed:
	docker exec $(image_name) bash -c "php artisan db:seed"

docker-up:
	./vendor/bin/sail up -d

docker-stop:
	./vendor/bin/sail stop
