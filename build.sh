#!/bin/bash

set -Eeuo pipefail

composer create-project laravel/laravel backend \
  && cp backend/.env.example backend/.env \
  && cp docker-files/Dockerfile backend/Dockerfile \
  && cp docker-files/command.sh backend/command.sh \
  && cp -r crontab backend/crontab \
  && npm create vite@latest frontend
