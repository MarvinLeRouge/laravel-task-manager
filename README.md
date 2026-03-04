# Laravel Task Manager — API Branch

A modern RESTful API for task management built with **Laravel 12** and **Sanctum**.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![Sanctum](https://img.shields.io/badge/Sanctum-4.0-201c44?style=flat&logo=laravel&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

> 💡 **This repo contains two implementations of the same app:**
> - **`main`** — Server-side rendering with Blade views
> - **`api`** *(this branch)* — REST API with Sanctum + Vue.js frontend in `/frontend`

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Running the Frontend](#-running-the-frontend)
- [API Authentication](#-api-authentication)
- [API Endpoints](#-api-endpoints)
- [Request/Response Examples](#-requestresponse-examples)
- [Filtering & Search](#-filtering--search)
- [Error Handling](#-error-handling)
- [Running Tests](#-running-tests)
- [Project Structure](#-project-structure)
- [License](#-license)

## 📖 Overview

This project provides a complete REST API for managing tasks and categories. It features token-based authentication using Laravel Sanctum, resourceful controllers, API Resources for consistent JSON responses, and comprehensive feature tests.

A lightweight Vue.js frontend (in `/frontend`) is included to interact with the API.

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
| **Frontend** | Vue.js 3, TypeScript, Pinia, Vue Router |

## 📦 Requirements

Ensure you have the following installed:

- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **Node.js** >= 18.x and **npm** (for the frontend)
- **SQLite** / MySQL / PostgreSQL
- **Git**

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone -b api https://github.com/MarvinLeRouge/laravel-task-manager.git
cd laravel-task-manager
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration

For SQLite (recommended for development):

```bash
touch database/database.sqlite
php artisan migrate
```

For MySQL/PostgreSQL, update `.env` with your credentials then run:

```bash
php artisan migrate
```

### 5. Start the API Server

```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

## 🖥 Running the Frontend

The Vue.js frontend lives in the `/frontend` directory and is a standalone project.

```bash
cd frontend
npm install
npm run dev
```

The frontend will be available at: `http://localhost:5173`

> ⚙️ By default, the frontend points to `http://localhost:8000`. If your API runs on a different port, update `frontend/src/lib/axios.ts` accordingly.

## 🔐 API Authentication

All endpoints except `/api/login` require authentication via Bearer token.

### Obtaining a Token

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
    "email": "user@example.com"
  }
}
```

### Using the Token

```bash
curl -X GET http://localhost:8000/api/tasks \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

### Revoking a Token

```bash
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN" \
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
  -d '{"name": "Work", "color": "#6366f1"}'
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

**Response (200 OK):**
```json
{
  "data": [
    { "id": 1, "name": "Work", "color": "#6366f1", "tasks_count": 3 },
    { "id": 2, "name": "Personal", "color": "#10b981", "tasks_count": 1 }
  ]
}
```

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
    "category": { "id": 1, "name": "Work", "color": "#6366f1" },
    "created_at": "2026-03-04T10:30:00.000000Z"
  }
}
```

## 🔍 Filtering & Search

| Parameter | Description | Example |
|-----------|-------------|---------|
| `status` | Filter by task status | `?status=done` |
| `priority` | Filter by priority level | `?priority=high` |
| `category_id` | Filter by category | `?category_id=1` |
| `search` | Search in title/description | `?search=Laravel` |

```bash
# High priority tasks in a specific category
curl -X GET "http://localhost:8000/api/tasks?priority=high&category_id=1" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

## ❌ Error Handling

| Status | Meaning | Example |
|--------|---------|---------|
| `401` | Missing or invalid token | `{"message": "Unauthenticated."}` |
| `404` | Resource not found | `{"message": "Not Found."}` |
| `422` | Validation error | `{"message": "...", "errors": {...}}` |

## 🧪 Running Tests

```bash
# Run all tests
php artisan test

# Run a specific test file
php artisan test tests/Feature/Api/TaskTest.php

# Run with coverage
php artisan test --coverage
```

### Test Coverage

| Test Class | Coverage |
|------------|----------|
| `AuthTest` | Login, logout |
| `CategoryTest` | Full CRUD |
| `TaskTest` | Full CRUD + filtering |

## 📁 Project Structure

```
laravel-task-manager/ (api branch)
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   ├── AuthController.php
│   │   │   ├── CategoryController.php
│   │   │   └── TaskController.php
│   │   └── Resources/
│   │       ├── CategoryResource.php
│   │       └── TaskResource.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       └── Task.php
├── frontend/                   ← Vue.js standalone app
│   ├── src/
│   │   ├── views/
│   │   ├── stores/
│   │   └── router/
│   └── package.json
├── routes/
│   └── api.php
└── tests/
    └── Feature/Api/
        ├── AuthTest.php
        ├── CategoryTest.php
        └── TaskTest.php
```

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

---

<div align="center">

**Built with ❤️ using Laravel 12 & Vue.js 3**

[⬆ Back to Top](#laravel-task-manager--api-branch)

</div>
