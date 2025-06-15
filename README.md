# Sistem Absensi

The application uses **Laravel** for the backend, **MySQL** for the database, and **PHP** with **Javascript** for the frontend.

## Setup Instructions

### Step 1: Clone the Repository

```bash
git clone https://github.com/hnifnurh/laravel-absensi.git
cd laravel-absensi
```

### Step 2: Install Dependencies

#### Backend

### Step 3: Environment Configuration

1. Copy the `.env` file:
   ```bash
   cp .env.example .env
   ```
2. Update the `.env` file with your local configuration:

   ```env
   APP_NAME=WebAbsensi
   APP_ENV=local
   APP_KEY=base64: GENERATE KEY
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_CONNECTION=mysql
   DB_HOST=db-absensi
   DB_PORT=3306
   DB_DATABASE=absensi
   DB_USERNAME=root
   DB_PASSWORD=
    
   DB_USERS_CONNECTION=mysql
   DB_USERS_HOST=db-users
   DB_USERS_PORT=3306
   DB_USERS_DATABASE=users
   DB_USERS_USERNAME=root
   DB_USERS_PASSWORD=

   SESSION_DRIVER=file
   SESSION_COOKIE=web_absensi_session
   QUEUE_CONNECTION=database

   VITE_BASE_URL=http://localhost
   ```
### Step 4: Open the XAMPP and Create Database

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

### Step 6: Run Migrations and Seeders

```bash
php artisan migrate --seed
```

### Step 7: Start the Development Server

```bash
php artisan serve
```

## Notes

Refer to the following usernames and passwords for seeded users (adjust based on your seeds):

| Role    | Username       | email                 | Password    |
| ------- | -------------- | --------------------- | ----------- |
| Admin   | Admin          | admin@example.com     | password123 |
| Manager | User           | user@example.com      | password123 |
