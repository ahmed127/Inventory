# Inventory
## Getting started

### Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/12.x)

Clone the repository

    git clone https://github.com//ahmed127/inventory.git

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Migrate tables

    php artisan migrate

Migrate tables with seeds

    php artisan migrate:fresh --seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

Run test

    ./vendor/bin/pest

EndPoints postman in project folder
* Collection: Inventory.postman_collection.json
* Environment: Local.postman_environment.json
