#!/bin/bash

set -Eeuo pipefail

composer install --optimize-autoloader --no-dev \
    && composer dump-autoload \
    && php artisan cache:clear \
    && php artisan config:clear \
    && php artisan view:clear \
    && php artisan key:generate \
    && php artisan serve --host=0.0.0.0
