cd docker &&
docker-compose up -d &&
docker-compose exec qst-php-web php artisan migrate:rollback &&
docker-compose exec qst-php-web php artisan migrate &&
docker-compose exec qst-php-web php artisan db:seed &&
docker-compose exec qst-php-web php artisan cache:clear &&
docker-compose exec qst-php-web php artisan storage:link &&
docker-compose exec qst-php-web php artisan l5-swagger:generate