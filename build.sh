#!/bin/bash

set -Eeuo pipefail

composer create-project laravel/laravel backend \
  && cp backend/.env.example backend/.env \
  && cp docker-files/Dockerfile backend/Dockerfile \
  && cp docker-files/command.sh backend/command.sh \
  && cp -r crontab backend/crontab

# Prompt the user for input to configure database access
read -p "Enter database name: " db_name
read -p "Enter database user: " db_user
read -p "Enter database password: " db_password
read -p "Enter database root password: " db_root_password

# Construct the content to append
content="\nDB_DATABASE=$db_name\nDB_USERNAME=$db_user\nDB_PASSWORD=$db_password\nDB_ROOT_PASSWORD=$db_root_password"

# Find and append to .env file
env_file=".env"
if [ -f "$env_file" ]; then
  echo -e "$content" >> "$env_file"
  echo "Values appended to $env_file"
else
  echo ".env file not found in the current directory."
fi

npm create vite@latest frontend
