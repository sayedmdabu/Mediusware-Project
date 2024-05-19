# Laravel Banking Application

This is a Laravel application that simulates a simple banking system. Users can register, log in, view their balance, and perform deposit and withdrawal transactions.

## Features

- User registration and login
- Deposit and withdrawal transactions
- Transaction fees based on account type
- User balance management
- Display user transactions and current balance

## Requirements

- PHP >= 8.2
- Laravel 11
- Composer
- MySQL

## Installation

### Step 1: Clone the Repository
```bash
git clone https://github.com/sayedmdabu/Mediusware-Project.git
cd Mediusware-Project
```

### Step 2: Install Dependencies
```bash
composer install or composer update
npm install
npm run dev
```

### Step 3: Set Up Environment Variables
```bash
cp .env-save .env
```

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Run Migrations
```bash
php artisan migrate
```

### Step 6: Serve the Application
```bash
php artisan serve
```
