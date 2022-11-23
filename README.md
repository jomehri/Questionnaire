## Questioner

## What's included:

- Dockerized
- Swagger API Documentation
- <b>Repository Design Pattern</b>
- <b>Race condition</b> prevention (database locks: both MySql & Redis)
- SOLID, DRY, OOP, KISS
- Feature tests
- Form request validation
- Localization and translates

## Installation:

- cd docker
- docker-compose build
- docker-compose up --remove-orphans
- cd ../src
- composer install
- cp .env.example .env
- cp .env.testing.example .env.testing
- sudo chmod 777 storage/ -R
- cd ../docker
- docker-compose exec qst-php-web php /var/www/html/artisan migrate:fresh
- visit http://localhost:9085 
