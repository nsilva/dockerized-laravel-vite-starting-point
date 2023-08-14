#!/bin/bash

docker pull php:8.1-apache \
  && docker-compose --env-file .env up --build
