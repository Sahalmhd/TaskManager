# Task Management System

## Overview
This is a Laravel-based Task Management System that allows users to create, edit, and delete tasks. It includes authentication, task prioritization, and AJAX-based operations for seamless user experience.

## Features
- User authentication
- Create, edit, and delete tasks
- Task status and priority management
- AJAX-based CRUD operations
- SweetAlert for confirmation dialogs
- Toastr for success and error notifications
- Bootstrap and FontAwesome for UI

## Technologies Used
- Laravel 12
- MySQL
- jQuery & AJAX
- Bootstrap 5
- Toastr.js (Notifications)
- SweetAlert2 (Confirmation dialogs)
- FontAwesome (Icons)

## Installation Guide

### 1. Clone the Repository
```bash
git clone https://github.com/Sahalmhd/TaskManager.git
cd task-management
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Configure Environment
Copy `.env.example` to `.env` and update database credentials:
```bash
cp .env.example .env
```
Then update the `.env` file with your database configuration:
```
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations and Seed Database
```bash
php artisan migrate --seed
```

### 6. Serve the Application
```bash
php artisan serve
```
Visit `http://127.0.0.1:8000` in your browser.

## Usage
- Login with test credentials (`test@example.com / password`) or create a new account.
- Create, edit, or delete tasks using the user interface.
- Use the dropdown menu in the task list for task actions.

## Additional Commands
If you need to refresh migrations and seed data:
```bash
php artisan migrate:fresh --seed
```



