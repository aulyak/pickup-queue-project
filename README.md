## Requirements

- Composer (PHP 7)
- MySQL database
- NPM

## Cloning and Installing the Application

- Clone this repo
- Go to project directory
- Run *composer install*
- Copy .env.example and rename it to .env
- Open .env file and change the database name (DB_DATABASE), username (DB_USERNAME) password (DB_PASSWORD) corresponding to your database configuration
- Run *php artisan key:generate*
- Run *php artisan migrate*
- Run *php artisan storage:link*
- Run *npm install* and *npm run dev*

## Running the Application

- Run *php artisan serve*
- Access it via http://localhost:8000/