#!/bin/bash

set -Eeuo pipefail

composer dump-autoload \
    && composer install --optimize-autoloader --no-dev \
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
elif [[ "$1" == "--schedule" ]]; then
    echo "Setting up Laravel Scheduler..."

    # Write the cron job entry to the crontab
    echo "* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1" | crontab -

    # Start the cron service
    cron -f
else
    echo "Invalid option. Usage: ./script.sh [--serve | --queue]"
fi
