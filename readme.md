# File Manager Microservice

This is a simple Microservice built in [Lumen](https://lumen.laravel.com) micro framework.

## Requirements

1. PHP `>= 7.1.3`
2. MySQL `>= 5.6`

## Installation Instructions

1. Clone the repo (`git clone...`)
2. Run `composer install` to install the application dependencies
3. Create a copy of `.env.example` and save it as `.env`
3. Create a database and enter the database credentials in the `.env` file
3. Run `php artisan migrate` to create the database tables

## Available Endpoints

- GET `/api/files` (get a list of all files)
- GET `/api/files/{id}` (get a single file)
- GET `/api/files/download/{id}` (download a file)
- GET `/api/files/total` (get total used space)
- POST `/api/files` (upload a file)
- DELETE `/api/files/{id}` (delete a file)

## Testing

- Run `phpunit` to run the unit tests
