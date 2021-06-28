#!/usr/bin/env bash

php composer.phar install
cd docker
docker-compose up --build -d
