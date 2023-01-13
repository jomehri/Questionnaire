cd docker &&
docker-compose up -d &&
docker-compose exec qst-php-web php artisan migrate:rollback &&
docker-compose exec qst-php-web php artisan migrate &&
docker-compose exec qst-php-web php artisan db:seed &&
docker-compose exec qst-php-web php artisan cache:clear &&
rm -Rf ../src/public/storage &&
docker-compose exec qst-php-web php artisan storage:link &&
docker-compose exec qst-php-web chmod 777 storage/ -R
docker-compose exec qst-php-web php artisan l5-swagger:generate