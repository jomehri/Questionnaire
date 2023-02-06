cd src && source .env;

APP_ENV=$(echo "$APP_ENV");
echo "Deploying $APP_ENV..........";

if [ "$APP_ENV" == "local" ]
then
   cd ../docker &&
   docker-compose up -d &&
   docker-compose exec qst-php-web php artisan migrate:rollback &&
   docker-compose exec qst-php-web php artisan migrate &&
   docker-compose exec qst-php-web php artisan db:seed &&
   docker-compose exec qst-php-web php artisan cache:clear &&
   docker-compose exec qst-php-web php artisan optimize &&
   rm -Rf ../src/public/storage &&
   docker-compose exec qst-php-web php artisan storage:link &&
   docker-compose exec qst-php-web chmod 777 storage/ -R &&
   docker-compose exec qst-php-web php artisan l5-swagger:generate
else
    sudo chown ubuntu:ubuntu -R ./ &&
    git stash &&
    git pull origin main &&
    sudo chown www-data:www-data -R ./ &&
    php artisan migrate --force &&
    php artisan db:seed --force &&
    php artisan cache:clear &&
    php artisan l5-swagger:generate &&
    sudo chmod 777 -R storage/ &&
    sudo chmod 777 -R bootstrap/ &&
    php artisan optimize

fi