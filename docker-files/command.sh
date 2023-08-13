#!/bin/bash

set -Eeuo pipefail

composer install --optimize-autoloader --no-dev \
    && php artisan cache:clear \
    && php artisan config:clear \

# Define the available options
serve_command="/usr/sbin/apache2ctl -DFOREGROUND"
queue_command="php artisan queue:work --tries=3"

# Check the command-line arguments
if [[ "$1" == "--serve" ]]; then
    echo "Running initial artisan commands..."
    php artisan migrate --force \
        && php artisan view:clear \
        && php artisan db:seed \
        && php artisan key:generate

    $serve_command \
        && echo "... and we are ready!!! Visit the application at http://localhost:8001"
elif [[ "$1" == "--queue" ]]; then
    echo "Executing: $queue_command"

    $queue_command
elif [[ "$1" == "--schedule" ]]; then
    echo "Setting up Laravel Scheduler..."

    chmod 0644 /etc/cron.d/container_cronjob \
        && touch /var/log/cron.log \
        && crontab /etc/cron.d/container_cronjob \
        && cron -f \
        && tail -f /var/log/cron.log

else
    echo "Invalid option. Usage: ./script.sh [--serve | --queue]"
fi
