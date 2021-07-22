#!/bin/bash

# First we create a docker environment
cp .env.example .env

docker-compose up -d --build --force-recreate


echo "\nCreating ** Database ** enviroment, please wait a minute"
sleep 60

docker exec -ti example_project_php bash -c "chmod -R 777 storage/ bootstrap"

docker exec -ti -u 1000 example_project_php bash -c "cp .env.example .env \
    && composer install \
    && php artisan key:gen \
    && php artisan migrate:refresh --seed"

docker exec -ti example_project_php bash -c "chmod -R 777 storage/ bootstrap"
docker exec -ti example_project_php bash -c "chown -R www-data:www-data storage bootstrap"

echo "\n\nNow you can visit http://localhost:5000\n"
echo "User: administrador@example.com\n"
echo "Pass: mario.sanchez2021"