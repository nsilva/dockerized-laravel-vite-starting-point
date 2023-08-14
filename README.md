# Laravel/Vite Project Starting Point with Docker
This repo has all the pieces to create a dockerized project with Laravel on the backend and Vite(Vue, React or whatever you choose) on the frontend. It will create the frontend and backend in separated folders so you have a real separation of concerns.

## Dependencies
- Composer
- NPM
- Vite
- Docker
- Docker Compose

## Installation
- Run `./build.sh`. This will create the "backend" folder and initialize the Laravel. Next, it will prompt for the database credentials. The credentials you enter here will be used to create the database container. It will also set the credentials in the Laravel .env file automatically. Then, the script will fire the Vite create script, where you will need to select the frontend framework and language. Once the script is done, you don't need to run `npm install` here. It will be done in the next step, within the Docker container.

- Run `./up.sh`. This will pull and start the Docker containers and will necessary `artisan` commands for the backend application, start the Laravel queue and install the frontend dependencies.

## Project Containers
Once built, the project will have Docker 7 containers:
- Frontend - (visit at localhost:8001)
Will run the Vite frontend application
- Backend - (visit at localhost:8002)
Will run the Laravel backend application
- Redis. Will be the caching layer for the Laravel application. You need to .env file in your Laravel application to use it if needed. If you need access from your host computer, you will need to update the docker-compose.yml file to map the corresponding port
- Queue worker. Will run the Laravel queue
- Scheduler. Will run the Laravel scheduler
- DB. The MySQL database
- PHPMyAdmin - (visit at localhost:8003)
A handy way To access the database
- Mailpit - (visit at localhost:8004)
It acts as both an SMTP server, and provides a web interface to view all captured emails for the dev environment

## Containers Access
If you need to access the containers via your command line(to executed `artisan` command for example or run tests) you can use any of the scripts created for that purpose. For example, to access the backend container, you can run `./access-backend.sh`.

Feel free to fork and update, I am sure this can be improved. I needed to build this for a development challenge and ended up spending more time on the Docker setup than in the challenge itself, so if it any way this saves you any time, please give a star.




