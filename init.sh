#!/usr/bin/env bash

php composer.phar install
cd docker
docker-compose up --build -d &&
    write "Please wait 10 seconds" &&
    sleep 10s &&
    docker exec a_booking-cli php create_tables
