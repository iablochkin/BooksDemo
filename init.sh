#!/bin/bash

docker compose build
docker compose up -d

docker compose exec php composer install
docker compose exec php php bin/console doctrine:database:create
docker compose exec php php bin/console doctrine:migrations:migrate

docker compose exec php php bin/console doctrine:fixtures:load