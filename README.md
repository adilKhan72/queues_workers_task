# Simple Job Queue System in PHP

This project implements a basic job queue system in PHP without using any external libraries (only standard PHP functions and SPL classes). It allows adding and retrieving jobs from different queues using a simple API.

## Features

*   **Queue Management:** Supports multiple queues (`maintenance`, `reject`, `purchase`).
*   **FIFO (First-In-First-Out):** Jobs are processed in the order they are added to the queue.
*   **Two Storage Drivers:** Supports storing queues in files or a MySQL database.
*   **API Endpoints:** Provides two API endpoints for adding and retrieving jobs.
*   **Error Handling:** Includes basic error handling and returns appropriate HTTP status codes.

## Requirements

*   PHP 7.4 or higher (for namespace support and other features used).
*   MySQL database (if using the 'database' queue driver).
*   XAMPP (or a similar web server environment) for local development.

## Installation

1.  **Set up the database (if using the 'database' driver):**

    *   Create a MySQL database named `queue_system`.
    *   Update the database credentials in `config.php`.

2.  **Configure the queue driver:**

    *   Open `config.php`.
    *   Set the `queue_driver` option to either `file` or `database`.
    *   If using the `file` driver, ensure the `storage` directory exists and is writable by the webserver.

3.  **Place the project in your web server's document root (e.g., `htdocs` in XAMPP).**

## API Endpoints

All endpoints are accessed through `endpoints`.

**1. Add a new job:**

*   **Method:** `GET`
*   **URL:** `http://your-domain/endpoints/new-job.php?queue=queue_name&job=job+description`
*   **Parameters:**
    *   `queue`: The name of the queue (`maintenance`, `reject`, or `purchase`).
    *   `job`: The description of the job.


**2. Get the next job:**

*   **Method:** `GET`
*   **URL:** `http://your-domain/endpoints/get-next-job.php?queue=queue_name`
*   **Parameters:**
    *   `queue`: The name of the queue.

## Directory Structure

queues_workers_task/
├── classes/          # Class files
│   ├── ApiRequestHandler.php
│   ├── DatabaseConnection.php
│   ├── DatabaseQueue.php
│   ├── FileQueue.php
│   ├── JobQueue.php
│   ├── QueueDriverFactory.php
│   └── QueueInterface.php
├── services/    
│   └── Validator.php
├── config.php        # Configuration file
└── storage/          # Storage for file-based queues
