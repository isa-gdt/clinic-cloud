
# Clinic Cloud

Tenchical assessment API



## Requirements

- Docker
- Make
## Installation

Build the docker image
```bash
  make build
```

Start Docker containers
```bash
  make up
```

## Database

The database script is located in the `database.sql` file within the `database/` directory at the root of the project. Use this script to set up the database schema and seed initial data.

The database has two main entities: tasks and users.

#### tasks Entity
Fields:

`id:` Primary key, auto-incremented.

`created_by:` Foreign key referencing the users table (user who created the task).

`assigned_to:` Foreign key referencing the users table (user assigned to the task).

`text:` A description of the task.

`status:` Enum field to define the status of the task (can be pending, in_progress, or completed).

`created_at:` Timestamp when the task was created.

`updated_at:` Timestamp when the task was last updated.

Indexes:

`created_by` and `status`: Combined index

#### users Entity
Fields:

`id: `Primary key, auto-incremented.

`name:` The name of the user.

`email:` The user's email (unique).

`password:`The user's password.

`created_at:` Timestamp when the user was created.

`updated_at:` Timestamp when the user was last updated.

#### Relationships:

A user can have multiple tasks assigned to them (`assigned_to`).

A user can also be the creator of multiple tasks (`created_by`).


## Documentation (Swagger)

The API documentation is available in the `openapi.yaml` file located in the root of this project. This file follows the OpenAPI 3.0 specification and contains all details about the available endpoints, request parameters, and responses.


## General Information

### Authentication
Users authenticate via JWT, which is issued with a duration of 2 hours. The protected routes in the application are secured with this authentication method. A middleware is used to verify the token and store the information of the logged-in user for further use in the application.

### Backend
The backend is built using Laravel (PHP) and MySQL with Eloquent ORM for the database.
Following a Hexagonal Architecture organized by Bounded Contexts and Domain-Driven Design (DDD) and has the following structure:
```
├── src
│   ├── Auth
│   │   ├── Application
│   │   │   ├── InputDTO
│   │   │   └── UseCase
│   │   ├── Domain
│   │   │   ├── Exception
│   │   │   ├── Repository
│   │   │   └── User.php
│   │   └── Infrastructure
│   │       ├── Controller
│   │       ├── Exception
│   │       ├── Model
│   │       └── Repository
│   ├── Common
│   │   ├── Application
│   │   │   └── Exception
│   │   ├── Domain
│   │   │   └── Collection.php
│   │   └── Infrastructure
│   │       └── Exception
│   └── ToDoList
│       ├── Application
│       │   ├── InputDTO
│       │   └── UseCase
│       ├── Domain
│       │   ├── Exception
│       │   ├── Repository
│       │   ├── TaskCollection.php
│       │   └── Task.php
│       └── Infrastructure
│           ├── Controller
│           ├── Model
│           ├── Repository
│           └── Transformer
```
#### Error Handling
Errors are handled globally in the bootstrap/app.php file. It listen for exceptions and return customized responses for each type of error, maintaining a consistent format for all error responses.

#### Routes
The backend exposes several RESTful API endpoints that can be used for managing tasks and users. The routes are protected by JWT authentication, ensuring that only authenticated users can access them.

`GET /tasks – Retrieve all tasks`

`POST /tasks – Create a new task`

`PUT /tasks/{id} – Update a task`

`DELETE /tasks/{id} – Delete a task`

`POST /login – Authenticate and generate a JWT token`

Example requests and responses for these endpoints can be found in the OpenAPI documentation located in the openapi.yaml file at the root of the project.

### Frontend
The frontend is built using JavaScript, CSS, and HTML and It is designed to be responsive.

The frontend consists of the following screens:

#### Login Screen:
This is where users can log in using their credentials (email and password). Upon successful login, a JWT token is issued for further authentication.

#### Dashboard:
After logging in, the user is directed to the dashboard where they can view and manage tasks. The dashboard displays all tasks, ordered by creation date in descending order (from the most recent to the oldest).

At the top of the dashboard, there is a header showing the logged-in user's email address and a logout button.
- Task Interaction:
  Clicking on a task opens a modal where you can edit the task's details.

Clicking the (+) button opens a modal to create a new task.

Each task has a trash icon buttom that allows you to delete the task.

- Pagination:
  At the bottom of the task list, there is a "Load more tasks" button.

Clicking this button loads the next page of tasks.
If there are no more tasks to load, the "Load more tasks" button is hidden.
## Available Make Commands

Stop the containers
```bash
  make down
```

Run tests with coverage
```bash
  make tests
```

## Next Steps

- Create value objects for the domain.
- Improve testing. Add acceptance tests and mutant testing.
- Improve logging with a log handler that uses a standardized format for all logs.
- Add cache layer.
- As the frontend is currently quite simple. There is no functionality in the frontend or backend to get a task by ID, which is something that will have to be implemented in a more complete version of the application..


