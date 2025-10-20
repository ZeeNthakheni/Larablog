# Admin Panel README

This document provides instructions on how to set up, configure, and deploy the admin panel.

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm
- SQLite

## Setup Instructions

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```
3.  **Configure the environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Create the database:**
    ```bash
    touch database/database.sqlite
    ```
5.  **Run migrations and seed the database:**
    ```bash
    php artisan migrate:fresh --seed
    ```
6.  **Build assets:**
    ```bash
    npm run build
    ```

## Admin Credentials

-   **Email:** admin@example.com
-   **Password:** password

## Deployment

1.  Follow the setup instructions on your server.
2.  Configure your web server to point to the `public` directory.
3.  Ensure the `storage` and `bootstrap/cache` directories are writable.
4.  For production, it is recommended to use a more robust database than SQLite.

## Available Routes

-   `/admin`: Admin dashboard
-   `/users`: User management
-   `/login`: Login page

## Running Tests

To run the test suite, use the following command:
```bash
php artisan test
```
