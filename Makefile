# Makefile

# Run docker compose in detached mode
up:
	docker compose up -d

up-test:
	docker compose -f compose.test.yml up -d

# Install composer dependencies
install-composer:
	docker compose exec app composer install

install-composer-test:
	docker compose -f compose.test.yml exec app-test composer install

# Copy .env.example to .env
copy-env:
	cp .env.example .env

# Generate application key
generate-key:
	docker compose exec app php artisan key:generate

generate-key-test:
	docker compose -f compose.test.yml exec app-test php artisan key:generate --env=testing

# Run database migrations
migrate:
	docker compose exec app php artisan migrate

migrate-test:
	docker compose -f compose.test.yml exec app-test php artisan migrate --env=testing

# Full setup: combine all steps
init: up install-composer copy-env generate-key migrate

init-test: up-test install-composer-test generate-key-test migrate-test

test:
	docker compose -f compose.test.yml exec app composer run-script test

.PHONY: up install-composer copy-env generate-key migrate init test up-test init-test install-composer-test generate-key-test migrate-test
