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

# Update the Laravel .env file with the DB connection details
# Path to the .env file
ENV_FILE="./backend/.env"

# Read the current values from the .env file
DB_HOST=$(grep "^DB_HOST=" "$ENV_FILE" | cut -d '=' -f2)
DB_DATABASE=$(grep "^DB_DATABASE=" "$ENV_FILE" | cut -d '=' -f2)
DB_USERNAME=$(grep "^DB_USERNAME=" "$ENV_FILE" | cut -d '=' -f2)
DB_PASSWORD=$(grep "^DB_PASSWORD=" "$ENV_FILE" | cut -d '=' -f2)

# Update the values
DB_HOST="db"
DB_DATABASE=$db_name
DB_USERNAME=$db_user
DB_PASSWORD=$db_password

# Write the updated values back to the .env file
sed -i "" "s#^DB_HOST=.*#DB_HOST=${DB_HOST}#" "$ENV_FILE"
sed -i "" "s#^DB_DATABASE=.*#DB_DATABASE=${DB_DATABASE}#" "$ENV_FILE"
sed -i "" "s#^DB_USERNAME=.*#DB_USERNAME=${DB_USERNAME}#" "$ENV_FILE"
sed -i "" "s#^DB_PASSWORD=.*#DB_PASSWORD=${DB_PASSWORD}#" "$ENV_FILE"


echo "Updated Laravel database connection details in Laravel .env file"

# Run the Vite app creator
npm create vite@latest frontend
