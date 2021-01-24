## Установка и запуск

1. `composer install`
1. `cp .env.example .env`
1. `php artisan key:generate`
1. `touch database/database.sqlite`
1. `configurate .env`
1. `php artisan migrate --seed`
1. `php artisan serve`
