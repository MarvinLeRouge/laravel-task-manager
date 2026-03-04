# Laravel Task Manager — Blade Branch

A modern task management application built with **Laravel 12**, **Blade**, **Tailwind CSS** and **Alpine.js**.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=flat&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green.svg)

> 💡 **This repo contains two implementations of the same app:**
> - **`main`** *(this branch)* — Server-side rendering with Blade views
> - **`api`** — REST API with Sanctum + Vue.js frontend in `/frontend`

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [Tests](#-tests)
- [About](#-about)
- [License](#-license)

## ✨ Features

### Task Management
- ✅ **Full CRUD** — Create, read, update and delete tasks
- 📊 **Statuses** — Todo, In Progress, Done
- 🔥 **Priorities** — Low, Medium, High
- 📅 **Due dates** — Set deadlines for each task
- 🔍 **Search** — Search by title and description
- 🏷️ **Filters** — Filter by status, priority and category

### Category Management
- 📁 Create custom categories
- 🎨 Hex color codes for visual identification
- 📂 Associate tasks with categories

### Authentication & Security
- 🔐 Full authentication system (Laravel Breeze)
- 👤 Secure registration and login
- ✉️ Email verification
- 🔑 Password reset
- 🛡️ Authorization Policies for task protection
- 👤 User profile management

### Multi-User Support
- 🔒 Each user owns their own tasks and categories
- 🚫 Data isolation per user

## 🛠 Tech Stack

| Backend | Frontend | Tools |
|---------|----------|-------|
| Laravel 12 | Blade Templates | Vite 7 |
| PHP 8.2+ | Tailwind CSS 4 | Alpine.js 3 |
| Eloquent ORM | Reusable Components | Laravel Pail |
| Migrations | Responsive Design | Laravel Pint |
| Form Requests | | PHPUnit |

## 📦 Requirements

- **PHP** >= 8.2
- **Composer**
- **Node.js** >= 18.x and **npm**
- **SQLite** (or MySQL / PostgreSQL)
- **Git**

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/MarvinLeRouge/laravel-task-manager.git
cd laravel-task-manager
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration

SQLite is used by default:

```bash
touch database/database.sqlite
php artisan migrate
```

For MySQL/PostgreSQL, update `.env` with your credentials then run `php artisan migrate`.

### 5. Compile Assets

```bash
# Development (with hot-reload)
npm run dev

# Production
npm run build
```

### 6. Start the Development Server

```bash
# Option 1: Composer script (recommended — starts server, queue, logs and vite)
composer dev

# Option 2: Laravel server only
php artisan serve
```

The application will be available at: `http://localhost:8000`

### Quick Setup Script

```bash
composer setup
```

This script automatically runs: `composer install`, copies `.env`, generates the app key, runs migrations, `npm install` and `npm run build`.

## 💡 Usage

| Command | Description |
|---------|-------------|
| `composer dev` | Start server with hot-reload |
| `composer test` | Run the test suite |
| `npm run dev` | Start Vite in development mode |
| `npm run build` | Compile assets for production |
| `php artisan migrate` | Run migrations |
| `php artisan migrate:fresh --seed` | Reset DB with seeders |

## 📁 Project Structure

```
laravel-task-manager/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CategoryController.php    # Category CRUD
│   │   │   ├── TaskController.php        # Task CRUD
│   │   │   ├── TaskFilterController.php  # Task filtering
│   │   │   └── ProfileController.php     # Profile management
│   │   └── Requests/
│   │       ├── StoreTaskRequest.php      # Task creation validation
│   │       ├── UpdateTaskRequest.php     # Task update validation
│   │       └── ...
│   ├── Models/
│   │   ├── Task.php
│   │   ├── Category.php
│   │   └── User.php
│   └── Policies/
│       └── TaskPolicy.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── tasks/
│   │   ├── categories/
│   │   ├── layouts/
│   │   └── components/
│   ├── js/
│   └── css/
├── routes/
│   ├── web.php
│   └── auth.php
└── tests/
    ├── Feature/
    └── Unit/
```

## 🧪 Tests

```bash
# Run all tests
composer test

# Or directly with PHPUnit
php artisan test
```

## 🎓 About

This project demonstrates key Laravel concepts through a fully functional application:

- MVC architecture with Laravel
- Authentication and authorization (Breeze + Policies)
- Form validation with Form Requests
- Eloquent relationships (One-to-Many)
- Automated testing with PHPUnit
- Frontend integration with Tailwind CSS and Alpine.js
- Asset bundling with Vite

For an API-first approach to the same application, see the [`api` branch](https://github.com/MarvinLeRouge/laravel-task-manager/tree/api).

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

---

<div align="center">

**Built with ❤️ using Laravel 12**

[⬆ Back to Top](#laravel-task-manager--blade-branch)

</div>
