# Task Manager - Laravel Application

A simple, clean Task Manager built with Laravel and Bootstrap 4, allowing users to create, view, update, delete, and mark tasks as completed or pending.

## Table of Contents

- [Overview / Approach](#overview--approach)
- [Assumptions](#assumptions)
- [Setup Instructions](#setup-instructions)
- [Features Implemented](#features-implemented)
- [Bonus Features Implemented](#bonus-features-implemented)
- [Project Structure](#project-structure)
- [Tech Stack](#tech-stack)

## Overview / Approach

- Built using Laravel's standard MVC structure with an added **Service Layer** (`App\Services\TaskService`) to keep business logic out of the Controller, making the code easier to maintain, extend, and test.
- Validation is handled through dedicated **Form Request** classes (`StoreTaskRequest`, `UpdateTaskRequest`) rather than inline validation in the Controller, keeping validation rules reusable and self-contained.
- The task status (`pending` / `completed`) is stored as an `enum` column at the database level for data integrity, so invalid statuses can never reach the database regardless of the entry point (form, API, tinker, etc.).
- Frontend is built with **Bootstrap 4** (via CDN, no build step or npm install required) and Blade templates, keeping the setup lightweight and fast to run locally.
- A quick "Mark as Completed / Pending" toggle button is available directly from the task list for fast status updates, in addition to full editing via the Edit form.
- Route Model Binding is used throughout (`Task $task` in controller methods) instead of manually querying by ID, keeping controller code short and expressive.
- Old input (`old()`) is preserved on validation failure for both the Create and Edit forms, so users never lose what they typed.

## Assumptions

- No authentication/user system was required by the task description, so all tasks are global (not tied to a specific user or account).
- The `show` route (viewing a single task in detail) is available automatically via Laravel's resource routing but not actively used in the UI, since the task list already displays all relevant task info (title, description preview, date, status).
- Task descriptions are optional, as specified in the requirements; empty descriptions are displayed as "—" in the task list for clarity.
- Search matches against both the task title and status, since the requirements mention filtering by either.
- Pagination is set to 10 tasks per page as a reasonable default; this can be adjusted in `TaskService::getAllTasks()`.

## Setup Instructions

### Requirements

- PHP 8.1 or higher
- Composer
- MySQL (or any Laravel-supported database)
- XAMPP / WAMP / Laravel Valet / any local PHP environment (optional, for local serving)

### Steps

1. **Clone the repository:**
```bash
   git clone https://github.com/Karimmohamed736/project-name.git
   cd Task_Manager
```

2. **Install PHP dependencies:**
```bash
   composer install
```

3. **Copy the environment file and generate the app key:**
```bash
   cp .env.example .env
   php artisan key:generate
```

4. **Configure your database credentials** in `.env`:
```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager
   DB_USERNAME=root
   DB_PASSWORD=
```

5. **Create the database** (e.g. via phpMyAdmin or the MySQL CLI):
```sql
   CREATE DATABASE task_manager;
```

6. **Run the migrations:**
```bash
   php artisan migrate
```

7. **Start the local development server:**
```bash
   php artisan serve
```

8. **Visit the app** in your browser:
```
http://127.0.0.1:8000
```

(You'll be redirected automatically to `/tasks`.)

## Features Implemented

- ✅ Create tasks — title (required), description (optional), status (required: Pending/Completed)
- ✅ View all tasks in a clean, Bootstrap-styled table with title, creation date, and status
- ✅ Edit task details with a pre-filled form
- ✅ Delete tasks with a Bootstrap confirmation modal before removal
- ✅ Toggle task status (Completed ⇄ Pending) directly from the task list
- ✅ Visual distinction for completed tasks (green row highlight + colored status badge)
- ✅ Form validation on both create and edit, with clear inline error messages
- ✅ Session-based success messages after every action (create, update, delete, toggle)
- ✅ Friendly empty state when no tasks exist yet

## Bonus Features Implemented

- ✅ **Search bar** — filter tasks by title or status, accessible from the task list page
- ✅ **Pagination** — 10 tasks per page; the search term is preserved across page navigation via `withQueryString()`

*Drag-and-drop reordering was not implemented in this version.*

## Project Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   └── TaskController.php       # Handles HTTP requests, delegates logic to TaskService
│   └── Requests/
│       ├── StoreTaskRequest.php     # Validation rules for creating a task
│       └── UpdateTaskRequest.php    # Validation rules for updating a task
├── Models/
│   └── Task.php                     # Eloquent model, search scope, isCompleted() helper
└── Services/
└── TaskService.php               # Business logic layer
database/
└── migrations/
└── xxxx_create_tasks_table.php  # tasks table schema
resources/
└── views/
├── layouts/
│   └── app.blade.php             # Shared layout: navbar, alerts, Bootstrap 4 CDN
└── tasks/
├── index.blade.php           # Task list, search, pagination, delete modal
├── create.blade.php          # Create task form
└── edit.blade.php            # Edit task form
routes/
└── web.php                           # Resource routes + custom toggle-status route
```
## Tech Stack

- **Backend:** Laravel (latest), PHP 8.1+
- **Frontend:** Bootstrap 4 (CDN), jQuery, Popper.js
- **Database:** MySQL
- **Templating:** Blade

## Notes for Reviewers

- All validation error messages and success notifications are displayed via the shared layout, so they appear consistently across every page.
- The Service Layer pattern was used to demonstrate separation of concerns; for a project this size a plain Controller would also be sufficient, but this structure scales better if the app grows (e.g. adding an API layer later).
```

