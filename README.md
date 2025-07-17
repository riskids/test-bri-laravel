# Laravel Application Setup Guide

## Prerequisites
- PHP 8.0+
- Composer
- Node.js & npm
- MySQL/MariaDB

## Installation
1. Clone the repository
2. Install dependencies:
```bash
composer install
npm install
```

3. Copy .env.example to .env and configure database settings:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

## Database Setup
1. Create database
2. Run migrations and seeders:
```bash
php artisan migrate --seed
```

## Running the Application
Start the development server:
```bash
php artisan serve
```

## Default Login Credentials
The following users are seeded in the database:

| Username | Email                  | Password | Role        |
|----------|------------------------|----------|-------------|
| 100001   | administrator@email.com | secret   | administrator |
| 100002   | operational@email.com   | secret   | operational   |
| 100003   | sales@email.com         | secret   | sales         |

Access the application at: http://localhost:8000
