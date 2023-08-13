#!/bin/bash

set -Eeuo pipefail

composer create-project laravel/laravel backend \
  && cp backend .env.example .env \
  && cp docker-scripts/Dockerfile backend/Dockerfile \
  && cp docker-scripts/command.sh backend/command.sh \
  && npm create vite@latest frontend
