#!/bin/bash
composer install
php artisan key:generate
php artisan config:cache
php artisan migrate
php artisan storage:link
php artisan serve --port 8080 --host 0.0.0.0
