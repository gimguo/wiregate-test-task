# Wiregate Test Task: Device Control Panel

This is a test task implementation for Wiregate. The application is a device control panel built with Laravel and Filament, designed to manage a company's equipment inventory.

## Features

-   Full CRUD functionality for devices.
-   Device health status calculation (Perfect, Good, Fair, Poor, N/A) based on its lifecycle.
-   Custom filtering by health status.
-   Full-text search by device name using Meilisearch.
-   Dashboard with a statistics overview widget.
-   Database seeding with an admin user and demo devices for easy testing.

## Tech Stack

-   Laravel 12
-   PHP 8.2+
-   Filament 3
-   MySQL
-   Meilisearch
-   Docker (via Laravel Sail)

## How to Run

**Prerequisites:**
-   Docker installed
-   Composer installed

**Installation Steps:**

1.  **Clone the repository and navigate into it:**
    ```bash
    git clone https://github.com/gimguo/wiregate-test-task.git
    cd wiregate-test-task
    ```

2.  **Copy the environment file:**
    ```bash
    cp .env.example .env
    ```

3.  **Build and start the application containers:**
    *(This command will build the local Docker image and start all services)*
    ```bash
    docker compose up -d --build
    ```

4.  **Install PHP dependencies (inside the running container):**
    ```bash
    docker compose exec laravel.test composer install
    ```

5.  **Generate the application key:**
    ```bash
    docker compose exec laravel.test php artisan key:generate
    ```

6.  **Run migrations and seed the database:**
    ```bash
    docker compose exec laravel.test php artisan migrate --seed
    ```

7.  **Configure Meilisearch and import data:**
    ```bash
    docker compose exec laravel.test php artisan scout:configure-meilisearch
    docker compose exec laravel.test php artisan scout:import "App\Models\Device"
    ```

## Accessing the Application

-   **Application URL:** [http://localhost](http://localhost)
-   **Admin Panel:** [http://localhost/admin](http://localhost/admin)

**Admin Credentials:**
-   **Email:** `admin@example.com`
-   **Password:** `password`

---
*Developed by Andrey Korolev*
