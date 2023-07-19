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
  - Routing
  - Testing
  - Emmiters
 
## Dependencies
- Node
- Docker
- Docker Compose

## How to use the application
For convenience, the application includes a seeder that creates a user with some to-dos. You can access with the following credentials:
Email: test@example.com
Password: password123

After logging in, you can create to-dos by entering the tasl in the main input and hit enter
![image](https://github.com/nsilva/dockerized-todo/assets/1390818/28358c88-db40-4568-8099-d14466c83b19)

Once the new to-do is created, it will be shown in the list below the main input, with the newest at the top
![image](https://github.com/nsilva/dockerized-todo/assets/1390818/831facb1-72df-4123-bbb3-5d9afc7b82e9)

The to-do box includes a "Add subtask" link, when clicked, it will display a new input to add subtask under the selected to-do. The subtasks will be displayed in the same box as the parent to-do

![image](https://github.com/nsilva/dockerized-todo/assets/1390818/fb31130c-d334-4ae2-92c7-a61016cfa202)

To the right of each entry, you can see two icons, the first indicates the status if the to-do, and the cog displays the changing status options when clicked.

![image](https://github.com/nsilva/dockerized-todo/assets/1390818/82f9591e-f15d-4015-9794-59dc85462272)

Please note the side effects of changing status:
- If a parent task is set as complete, all the subtasks should be set as complete
- If a subtask is set as in progress and the parent to-do is not in progress, it will be forced to be in progress
  
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
- Policies: A policy has been used to determine if a user can view or edit a task
- Sanctum: The authentication is done using Sanctum to issue access token and as middleware to validate the token in each request
- Scheduler/Command: A command is in charge of fetching the uses with pending taks for more than 24 hours, along with the number of pendings tasks. The command is scheduled to execute every 5 minutes for testing purposes.
- Relationships: Givem that tasks and subtasks have the same properties, the `Todo` model was set to have a relationship with itself, so that if the `parent_id` is null, it is a parent task, otherwise it is a subtask.
- Enums: To handle the different possible statuses for a task, the newly introduced PHP `enum` structure has been used to have more flexibility if a new status is introduced.

Additionally, basic testing coverage was created to test the API request responses.

## Frontend (Vue)
The frontend application handles the user login, account creation and to-dos creation/update. The implementation uses some basics concepts of the framework:
- Component reusability: It is clearly seen in the To-Dos screen, where `Todo` component renders copies of itself if the task has subtasks.
- Routing: To render the different screens, the Vue router is used for redirection
- Testing: Basic tests were created using Vitest. Tbis is just a demostration on testing and far from being a proper test coverage.
- Emitters: Severals emitters are used across the applicationn to handle the diferent event caused by adding/updating tasks.

## Other considerations
For the styling, I used Tailwind with nested styles. I also used Vite to create the Vue project

## Relevant URLs

- UI: localhost:8001
- API: localhost:8002
- DBAdmin: localhost:8003
- Mail Inbox: localhost:8004

## Possible Improvements
There are several opportunities to imporve this application, but for the pusposes it was created, I believe it covers pretty much everything. At the time fo writing, there quite a few improvement I can thing of:
- Improve testing coverage
- Filter tasks by status
- Remove tasks marked as completed from the main list
- Add an email confirmation message upon registration
- Although the API side is really small, it could include API documentation
- The CSS styling could be more organized but I wanted to experiemnt with the different ways to use Tailwind



