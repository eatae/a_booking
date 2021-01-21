#!/usr/bin/env bash

php composer.phar install
cd docker
docker-compose up --build -d
docker exec a_booking-cli php create_tables
