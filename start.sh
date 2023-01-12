cd docker &&
docker-compose up -d &&
docker-compose exec qst-php-web php artisan migrate:rollback &&
docker-compose exec qst-php-web php artisan migrate