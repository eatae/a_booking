

git clone ... a-booking

cd ./docker
docker-compose up --build -d



Docker-Compose up:
    docker-compose up --build -d
    docker-compose -f ./docker/docker-compose.yml up --build -d

Docker-Compose down:
    docker-compose down
    docker-compose -f ./docker/docker-compose.yml down

php create_tables




---------

docker/db_data
    - общая директория для хранения БД


Url:

    localhost:8090
    a-booking:8090

Php-cli:
    docker exec -it a-booking-cli bash
