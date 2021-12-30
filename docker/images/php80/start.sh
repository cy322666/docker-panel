#!/bin/bash

PHP=/usr/local/bin/php

composer install

php artisan key:generate
php artisan migrate
php artisan orchid:install
php artisan orchid:admin root soft@gigwork.ru jsd**384378JJK

php-fpm