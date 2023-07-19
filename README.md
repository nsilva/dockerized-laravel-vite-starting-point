# To-Do Application

## Summary
This is more than just the typical to-do app. This app demostrate the use of several concepts
- Doker and Docker Compose
- Laravel/PHP Backend
  - Queues(Redis)
  - Notifications
  - Observers
  - Policies
  - Sanctum Authentication
  - Scheduler
  - Relationships
  - Enums
  - Commands
    
- Vue Frontend
  - Components Reusability
  - Testing
  - Emmiters
 
## Dependencies
- Node
- Docker
- Docker Compose

## How to Run this project
To run the project run `up.sh`, this will start the Docker container. The UI will be availeble at `localhost:8001`, addtionally, the MySQL database can be accessed at `localhost:8001` and the email inbox, where the system emails will land will be located at `localhost:8004`.

## Infrastructure(Docker)
The project infrastrcuture is build upon Docker with Docker Compose. At the root folder you can find the `docker-compose.yml` file. The defined containers are as follows:
- front-end: This container will hold the Vue frontend. The volumes will map the `frontend` folder.
- backedn-laravel: This container holds the Laravel application. The volumes will map the `backend` folder.
- redis: This will hols the redis instance to be used by the `queue` container.
- queue-worker: This container will be in change of running the queue worker.
- scheduler: This container will run the Laravel scheduler necessary for the tasks in progress for more than 24 hours by running `reminder:send` command
- db: This container run the project's database
- phpmyadmin: This container facilitates the visual access to the database on `localhost:8003` with PHPMyAdmin.
- mailpit: This container hold the Mailpit inbox where the system email will land.

## Backend (Laravel)
The Laravel backend leverages several features from the framework
- Queues: For the tasks that are in progress for more than 24 hours, it is necessary to notify the users about the pending tasks. Since email notifications can be a slow process, the emailing is processed in queue using Redis.
- Notifications: The pending tasks email is send using the notifications system, where each use with pending tasks is notified vis email
- Observers: It is assumed that updating a task can have side effects in two cases
  - If a parent task is not in progress and a child task is set to in progress, the parent task should be set to in progress as well
  - If a parent task is set as complete, all the subtasks should be set as complete
 To cover theses cases, a model observer was used to observe the `updated` event
docker pull php:8.1-apache && docker-compose up --build

UI localhost:8001
BE localhost:8002
DBAdmin localhost:8003
Inbox localhost:8025


