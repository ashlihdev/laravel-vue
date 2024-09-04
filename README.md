# Vue APP

## Installation

Silakan clone repo ini, lalu buat file .env dan atur databasenya.

1. Install dependency dulu:

```sh
composer install
npm install
```

2. Run database migration:

```sh
php artisan migrate
```

3. Run user seeder migration:

```sh
php artisan migrate:fresh --seed --seeder=UserSeeder
```

4. Serve

```sh
php artisan serve
```
