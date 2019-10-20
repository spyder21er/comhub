# comhub
A web-based communication platform for late night passengers and drivers.

# Prerequisites

PHP v7.2 or above

$ sudo apt install php7.2

Composer

$ sudo apt install composer

# Installing and setting up.

1. Clone
$ git clone git@github.com:spyder21er/comhub.git
2. Change directory
$ cd comhub
3. Install dependencies using composer
$ composer install
4. Make a copy of .env file
$ cp .env.example .env
5. Create app key.
$ php artisan key:generate
6. Setup your desired database server.
7. Setup environment in .env file.
8. Choose and setup your server or you can use php server for testing only.
$ php artisan serve --host=hostname --port=port_number

Enjoy!

