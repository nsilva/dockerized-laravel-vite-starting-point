# Laravel/Vite Project Starting Point with Docker
This repo has all the pieces to create a dockerized project with Laravel on the backend and Vite(Vue, React or whatever you choose) on the frontend. It will create the frontend and backend in separated folders so you have a real separation of concerns.

## Dependencies
- Composer
- Docker
- Docker Compose

## Project Containers
Once built, the project will have 7 containers:
- Frontend - Visit at localhost:8001
Will run the Vite frontend application
- Backend - Visit at localhost:8002
Will run the Laravel backend application
- Redis. Will be the caching layer for the Laravel application. You need to .env file in your Laravel application to use it if needed. If you need access from your host computer, you will need to update the docker-compose.yml file to map the corresponding port
- Queue worker. Will run the Laravel queue
- Scheduler. Will run the Laravel scheduler
- DB. The MySQL database
- PHPMyAdmin - Visit at localhost:8003
A handy way To access the database
- Mailpit - Visit at localhost:8004
It acts as both an SMTP server, and provides a web interface to view all captured emails for the dev environment

## Installation






