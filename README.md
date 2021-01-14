### Install

***

Clone:

    git clone https://github.com/eatae/a_booking.git ./a_booking

Переходим в директорию проекта:

	cd ./a_booking

Composer install:

	php composer.phar install

Переходим в директорию docker:

	cd ./docker

В собираем и запускаем образы:

	docker-compose up --build -d

Заходим в контейнер:

	docker exec -it a_booking-cli bash

Запускаем скрипт для создания DB:
 
	php create_tables

Выходим из контейнера:

	exit

Проверяем API:

	curl -X GET 'http://localhost:8092/api/room/list'


### Docs
***

#### Entity Room:
* id
* description
* price
* created_at

##### List method:
    {GET} /room/list
    Params:
        order:      in: price|created_at    (nullable)
        sort:       in: asc|desc            (nullable)
    Example:
        curl -X GET 'http://localhost:8092/api/room/list'
        curl -X GET 'http://localhost:8092/api/room/list?order=created'
        curl -X GET 'http://localhost:8092/api/room/list?order=created_at&sort=desc'
        curl -X GET 'http://localhost:8092/api/room/list?order=price&sort=asc'


##### Create method:
    {POST} /room/create
    Params:
        description:    string      (require)
        price:  	    integer     (require)
    Example:
        curl -X POST 'http://localhost:8092/api/room/create' -d 'description=Some text' -d 'price=330'
        curl -X POST 'http://localhost:8092/api/room/create' -d 'description=Any text' -d 'price=630'


##### Delete method:
    {DELETE} /room/delete
    Params:
        room_id:        integer     (require)
    Example:
        curl -X DELETE 'http://localhost:8092/api/room/delete' -d 'room_id=22'
        curl -X DELETE 'http://localhost:8092/api/room/delete' -d 'room_id=4'

***

#### Entity Booking:
* id
* room_id
* date_start  (Y-m-d)
* date_end	(Y-m-d)

##### List method:
    {GET} /booking/list
    Params:
        room_id:        integer         (nullable)
        sort:           in: asc|desc    (nullable)
    Example:
        curl -X GET 'http://localhost:8092/api/booking/list'
        curl -X GET 'http://localhost:8092/api/booking/list?sort=desc'
        curl -X GET 'http://localhost:8092/api/booking/list?sort=desc&room_id=2'
        curl -X GET 'http://localhost:8092/api/booking/list?sort=desc&room_id=22'
	

##### Create method:
    {POST} /booking/create
    params:
        room_id: 		integer	 	(require)
        date_start:  	date:Y-m-d 	(require)
        date_end:	  	date:Y-m-d 	(require)
    Example:
        curl -X POST 'http://localhost:8092/api/booking/create' -d 'room_id=2' -d 'date_start=2021-02-01' -d 'date_end=2021-02-02'
        curl -X POST 'http://localhost:8092/api/booking/create' -d 'room_id=22' -d 'date_start=2021-02-01' -d 'date_end=2021-02-02'
        curl -X POST 'http://localhost:8092/api/booking/create' -d 'room_id=2' -d 'date_start=2021-02-01' -d 'date_end=2021-01-22'
        curl -X POST 'http://localhost:8092/api/booking/create' -d 'room_id=2' -d 'date_start=2021-2-1' -d 'date_end=2021-01-02'


##### Delete method:
    {DELETE} /booking/delete
    Params:
        booking_id:         integer         (require)
    Example:
        curl -X DELETE 'http://localhost:8092/api/booking/delete' -d 'booking_id=4'
        curl -X DELETE 'http://localhost:8092/api/booking/delete' -d 'booking_id=22'


