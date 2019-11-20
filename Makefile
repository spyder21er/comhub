build:
    cp .env.sqlite .env
    composer install
    php artisan key:generate
    touch database/database.sqlite
    php artisan migrate:fresh --seed
