## Laravel-UnitTest

### Installation

```shell
docker compose up -d
docker compose exec app composer install
cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

### Run Test

### Volume Reset

```shell
docker compose down -v
docker compose up -d
sleep 5
docker compose exec app php artisan migrate
```
