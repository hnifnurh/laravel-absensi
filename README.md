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

```bash
composer install
```

### Step 3: Environment Configuration

1. Copy the `.env` file:
   ```bash
   cp .env.example.fix .env
   ```
2. Update the `.env` and `config/database.php` file with your local configuration:

   ```env
   APP_NAME=WebAbsensi
   APP_ENV=local
   APP_KEY=base64: GENERATE KEY
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=absensi
   DB_USERNAME=root
   DB_PASSWORD=
    
   DB_USERS_CONNECTION=mysql
   DB_USERS_HOST=127.0.0.1
   DB_USERS_PORT=3306
   DB_USERS_DATABASE=users
   DB_USERS_USERNAME=root
   DB_USERS_PASSWORD=

   SESSION_DRIVER=file
   SESSION_COOKIE=web_absensi_session
   CACHE_STORE=file
   QUEUE_CONNECTION=database

   VITE_BASE_URL=http://localhost
   ```

   ```config/database.php
           'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'absensi'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'users_mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_USERS_HOST', '127.0.0.1'),  
            'port' => env('DB_USERS_PORT', '3306'),
            'database' => env('DB_USERS_DATABASE', 'users'),
            'username' => env('DB_USERS_USERNAME', 'root'),
            'password' => env('DB_USERS_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
   ```
   
### Step 4: Open the XAMPP and Create Database

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

### Step 6: Run Migrations and Seeders

```bash
php artisan migrate:fresh --path=database/migrations/absensi --database=mysql
php artisan migrate:fresh --path=database/migrations/users --database=users_mysql

or
php artisan db:seed --class=UserSeeder
```

### Step 7: Start the Development Server

```bash
php artisan serve --port=8001
```

## Notes

Refer to the following usernames and passwords for seeded users (adjust based on your seeds):

| Role    | Username       | email                 | Password    |
| ------- | -------------- | --------------------- | ----------- |
| Admin   | Admin          | admin@example.com     | password123 |
| User    | User           | user@example.com      | password123 |
