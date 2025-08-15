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

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/gimguo/wiregate-test-task.git
    cd wiregate-test-task
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Copy the environment file:**
    ```bash
    cp .env.example .env
    ```

4.  **Start the Docker containers:**
    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Run database migrations and seed the data:**
    *(This command will create all tables and populate the database with an admin user and 5 demo devices)*
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

6.  **Import data into Meilisearch:**
    *(This step is necessary to enable search functionality)*
    ```bash
    ./vendor/bin/sail artisan scout:import "App\Models\Device"
    ```

## Accessing the Application

-   **Application URL:** [http://localhost](http://localhost)
-   **Admin Panel:** [http://localhost/admin](http://localhost/admin)

**Admin Credentials:**
-   **Email:** `admin@example.com`
-   **Password:** `password`

---
*Developed by Andrey Korolev*
