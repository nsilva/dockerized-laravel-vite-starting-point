#!/bin/bash

set -Eeuo pipefail

composer install --optimize-autoloader --no-dev \
    && composer dump-autoload \
    && php artisan cache:clear \
    && php artisan config:clear \
    && php artisan view:clear

# Define the available options
serve_command="php artisan serve --host=0.0.0.0"
queue_command="php artisan queue:work --tries=3"

# Check the command-line arguments
if [[ "$1" == "--serve" ]]; then
    echo "Running migrations..."
    php artisan migrate
    echo "Executing: $serve_command"
    $serve_command
elif [[ "$1" == "--queue" ]]; then
    echo "Executing: $queue_command"
    $queue_command
else
    echo "Invalid option. Usage: ./script.sh [--serve | --queue]"
fi
