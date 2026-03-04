# Laravel Task Manager API

A modern RESTful API for task management built with **Laravel 12** and **Sanctum**.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![Sanctum](https://img.shields.io/badge/Sanctum-4.0-201c44?style=flat&logo=laravel&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [API Authentication](#-api-authentication)
- [API Endpoints](#-api-endpoints)
- [Request/Response Examples](#-requestresponse-examples)
- [Filtering & Search](#-filtering--search)
- [Error Handling](#-error-handling)
- [Running Tests](#-running-tests)
- [Project Structure](#-project-structure)
- [Contributing](#-contributing)
- [Cleanup Notes - Legacy Blade Components](#-cleanup-notes---legacy-blade-components)
- [License](#-license)

## 📖 Overview

This project provides a complete REST API for managing tasks and categories. It features token-based authentication using Laravel Sanctum, resourceful controllers, API Resources for consistent JSON responses, and comprehensive feature tests.

## ✨ Features

### Authentication
- 🔐 **Token-based auth** using Laravel Sanctum
- 🔑 Secure login/logout endpoints
- 🛡️ Protected routes with `auth:sanctum` middleware

### Tasks Management
- ✅ Full CRUD operations for tasks
- 📊 Status tracking: `todo`, `in_progress`, `done`
- 🔥 Priority levels: `low`, `medium`, `high`
- 📅 Due date support
- 🔍 Search by title and description
- 🏷️ Filter by status, priority, and category
- 📎 Category association

### Categories Management
- 📁 Create and manage custom categories
- 🎨 Hex color codes for visual identification
- 📊 Task count per category

### Multi-User Support
- 🔒 User isolation - each user has their own tasks and categories
- 🚫 Automatic scoping via authentication

## 🛠 Tech Stack

| Component | Technology |
|-----------|------------|
| **Framework** | Laravel 12 |
| **PHP Version** | 8.2+ |
| **Authentication** | Laravel Sanctum 4 |
| **Database** | SQLite (default), MySQL, PostgreSQL |
| **Testing** | PHPUnit |
| **API Format** | JSON |

## 📦 Requirements

Ensure you have the following installed:

- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **SQLite** / MySQL / PostgreSQL
- **Git**

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/MarvinLeRouge/laravel-task-manager-api.git
cd laravel-task-manager-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

For SQLite (recommended for development):

```bash
touch database/database.sqlite
php artisan migrate
```

For MySQL/PostgreSQL, update `.env` with your credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Then run migrations:

```bash
php artisan migrate
```

### 5. Start the Server

```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

## ⚙️ Configuration

### Environment Variables

Key variables in `.env`:

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_URL` | Base URL for the API | `http://localhost` |
| `DB_CONNECTION` | Database driver | `sqlite` |
| `SANCTUM_STATEFUL_DOMAINS` | Domains for stateful auth | `localhost,127.0.0.1` |

## 🔐 API Authentication

All endpoints except `/api/login` require authentication via Bearer token.

### Obtaining a Token

Send a POST request to `/api/login` with credentials:

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"email":"user@example.com","password":"password"}'
```

**Response:**
```json
{
  "token": "3|AbCdEfGhIjKlMnOpQrStUvWxYz1234567890",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "user@example.com",
    "email_verified_at": null,
    "created_at": "2026-03-04T10:00:00.000000Z",
    "updated_at": "2026-03-04T10:00:00.000000Z"
  }
}
```

### Using the Token

Include the token in the `Authorization` header for all protected requests:

```bash
curl -X GET http://localhost:8000/api/tasks \
  -H "Authorization: Bearer 3|AbCdEfGhIjKlMnOpQrStUvWxYz1234567890" \
  -H "Accept: application/json"
```

### Revoking a Token

```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer 3|AbCdEfGhIjKlMnOpQrStUvWxYz1234567890" \
  -H "Accept: application/json"
```

## 📡 API Endpoints

### Authentication

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| `POST` | `/api/login` | Authenticate and get token | ❌ |
| `POST` | `/api/logout` | Revoke current token | ✅ |

### Categories

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| `GET` | `/api/categories` | List all categories | ✅ |
| `POST` | `/api/categories` | Create a category | ✅ |
| `GET` | `/api/categories/{id}` | Get category details | ✅ |
| `PUT` | `/api/categories/{id}` | Update a category | ✅ |
| `DELETE` | `/api/categories/{id}` | Delete a category | ✅ |

### Tasks

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| `GET` | `/api/tasks` | List all tasks | ✅ |
| `POST` | `/api/tasks` | Create a task | ✅ |
| `GET` | `/api/tasks/{id}` | Get task details | ✅ |
| `PUT` | `/api/tasks/{id}` | Update a task | ✅ |
| `DELETE` | `/api/tasks/{id}` | Delete a task | ✅ |

## 📝 Request/Response Examples

### Categories

#### Create Category

```bash
curl -X POST http://localhost:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Work",
    "color": "#6366f1"
  }'
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 1,
    "name": "Work",
    "color": "#6366f1",
    "tasks_count": 0
  }
}
```

#### List Categories

```bash
curl -X GET http://localhost:8000/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Work",
      "color": "#6366f1",
      "tasks_count": 3
    },
    {
      "id": 2,
      "name": "Personal",
      "color": "#10b981",
      "tasks_count": 1
    }
  ]
}
```

#### Update Category

```bash
curl -X PUT http://localhost:8000/api/categories/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Work Projects",
    "color": "#3b82f6"
  }'
```

#### Delete Category

```bash
curl -X DELETE http://localhost:8000/api/categories/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (204 No Content)**

---

### Tasks

#### Create Task

```bash
curl -X POST http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "title": "Learn Laravel Sanctum",
    "description": "Study token-based authentication",
    "category_id": 1,
    "status": "todo",
    "priority": "high",
    "due_date": "2026-03-15"
  }'
```

**Response (201 Created):**
```json
{
  "data": {
    "id": 1,
    "title": "Learn Laravel Sanctum",
    "description": "Study token-based authentication",
    "status": "todo",
    "priority": "high",
    "due_date": "2026-03-15",
    "category": {
      "id": 1,
      "name": "Work",
      "color": "#6366f1",
      "tasks_count": 1
    },
    "created_at": "2026-03-04T10:30:00.000000Z"
  }
}
```

#### List Tasks

```bash
curl -X GET http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (200 OK):**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Learn Laravel Sanctum",
      "description": "Study token-based authentication",
      "status": "todo",
      "priority": "high",
      "due_date": "2026-03-15",
      "category": {
        "id": 1,
        "name": "Work",
        "color": "#6366f1"
      },
      "created_at": "2026-03-04T10:30:00.000000Z"
    }
  ]
}
```

#### Update Task

```bash
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "title": "Master Laravel Sanctum",
    "description": "Complete authentication implementation",
    "status": "in_progress",
    "priority": "high",
    "due_date": "2026-03-15"
  }'
```

#### Delete Task

```bash
curl -X DELETE http://localhost:8000/api/tasks/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Response (204 No Content)**

## 🔍 Filtering & Search

The `/api/tasks` endpoint supports query parameters for filtering:

| Parameter | Description | Example |
|-----------|-------------|---------|
| `status` | Filter by task status | `?status=done` |
| `priority` | Filter by priority level | `?priority=high` |
| `category_id` | Filter by category | `?category_id=1` |
| `search` | Search in title/description | `?search=Laravel` |

### Examples

**Get all completed tasks:**
```bash
curl -X GET "http://localhost:8000/api/tasks?status=done" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Get high priority tasks in a category:**
```bash
curl -X GET "http://localhost:8000/api/tasks?priority=high&category_id=1" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

**Search tasks:**
```bash
curl -X GET "http://localhost:8000/api/tasks?search=Laravel" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

## ❌ Error Handling

### Authentication Errors

**401 Unauthorized** - Missing or invalid token:
```json
{
  "message": "Unauthenticated."
}
```

### Validation Errors

**422 Unprocessable Entity** - Invalid request data:
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password field is required."]
  }
}
```

### Not Found

**404 Not Found** - Resource doesn't exist:
```json
{
  "message": "Not Found."
}
```

## 🧪 Running Tests

The project includes comprehensive feature tests for all API endpoints.

```bash
# Run all tests
composer test

# Or using artisan
php artisan test

# Run specific test file
php artisan test tests/Feature/Api/TaskTest.php

# Run with coverage
php artisan test --coverage
```

### Test Coverage

| Test Class | Coverage |
|------------|----------|
| `AuthTest` | Login, logout functionality |
| `CategoryTest` | CRUD operations for categories |
| `TaskTest` | CRUD operations for tasks |

## 📁 Project Structure

```
laravel-task-manager-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       ├── AuthController.php      # Token authentication
│   │   │       ├── CategoryController.php  # Category CRUD
│   │   │       └── TaskController.php      # Task CRUD + filtering
│   │   └── Resources/
│   │       ├── CategoryResource.php        # Category JSON transformation
│   │       └── TaskResource.php            # Task JSON transformation
│   └── Models/
│       ├── User.php                        # User model with Sanctum
│       ├── Category.php                    # Category model
│       └── Task.php                        # Task model
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_03_02_073212_create_categories_table.php
│   │   ├── 2026_03_02_073225_create_tasks_table.php
│   │   └── 2026_03_03_084422_create_personal_access_tokens_table.php
│   └── factories/                          # Model factories for testing
├── routes/
│   └── api.php                             # API route definitions
├── tests/
│   └── Feature/
│       └── Api/
│           ├── AuthTest.php
│           ├── CategoryTest.php
│           └── TaskTest.php
├── config/
│   └── sanctum.php                         # Sanctum configuration
└── composer.json
```

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Setup

```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Run tests to verify setup
composer test
```

## 🧹 Cleanup Notes - Legacy Blade Components

> ⚠️ **Important:** This repository was originally cloned from a Laravel Blade view-based version. After conversion to an API-only architecture, several legacy files remain that are no longer used by the API.

### Context

This project has been refactored from a traditional Laravel MVC application (using Blade templates) to a pure REST API. The API now handles all functionality through:
- `app/Http/Controllers/Api/*` controllers
- JSON Resources for response transformation
- Sanctum token authentication

### Legacy Files to Remove

In a production context (non-exercise), the following files and directories should be **safely deleted** as they are only used by the Blade frontend and are not referenced by the API:

#### Controllers (Blade-specific)
```
app/Http/Controllers/CategoryController.php
app/Http/Controllers/TaskController.php
app/Http/Controllers/TaskFilterController.php
app/Http/Controllers/ProfileController.php
app/Http/Controllers/Auth/              # Entire directory (9 files)
```

#### Routes (Web/Blade)
```
routes/web.php
routes/auth.php
```

#### Views (Blade templates)
```
resources/views/  # Entire directory
```

#### Form Requests (Blade validation)
```
app/Http/Requests/StoreCategoryRequest.php
app/Http/Requests/UpdateCategoryRequest.php
app/Http/Requests/StoreTaskRequest.php
app/Http/Requests/UpdateTaskRequest.php
app/Http/Requests/ProfileUpdateRequest.php
```

#### Policies (Unused)
```
app/Policies/TaskPolicy.php  # All methods return false, not used by API
```

#### Frontend Assets (if no separate frontend)
```
resources/css/app.css
resources/js/app.js
resources/js/bootstrap.js
frontend/  # Only if not using a separate Vue/React frontend
```

#### Configuration Cleanup

After removing the above files, update `bootstrap/app.php` to remove web route references:

```php
// Before
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

// After
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
```

### Files to KEEP (API-specific)

| File/Directory | Purpose |
|----------------|---------|
| `app/Http/Controllers/Api/` | API controllers |
| `app/Http/Resources/` | JSON Resource classes |
| `routes/api.php` | API route definitions |
| `config/sanctum.php` | Sanctum configuration |
| `tests/Feature/Api/` | API feature tests |
| `database/migrations/*_tokens_table.php` | Sanctum tokens table |

### Recommended Cleanup Commands

```bash
# Remove Blade controllers
rm -rf app/Http/Controllers/Auth
rm app/Http/Controllers/CategoryController.php
rm app/Http/Controllers/TaskController.php
rm app/Http/Controllers/TaskFilterController.php
rm app/Http/Controllers/ProfileController.php

# Remove Blade routes
rm routes/web.php
rm routes/auth.php

# Remove Blade views
rm -rf resources/views

# Remove Form Requests
rm app/Http/Requests/StoreCategoryRequest.php
rm app/Http/Requests/UpdateCategoryRequest.php
rm app/Http/Requests/StoreTaskRequest.php
rm app/Http/Requests/UpdateTaskRequest.php
rm app/Http/Requests/ProfileUpdateRequest.php

# Remove Policies
rm -rf app/Policies

# Remove frontend assets (if not using separate frontend)
rm -rf resources/css resources/js frontend
rm tailwind.config.js postcss.config.js vite.config.js package.json package-lock.json
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

---

## 📞 Support

For issues and feature requests, please create an issue on the [GitHub repository](https://github.com/MarvinLeRouge/laravel-task-manager-api/issues).

---

<div align="center">

**Built with ❤️ using Laravel 12**

[⬆ Back to Top](#laravel-task-manager-api)

</div>
