cd src && source .env;

APP_ENV=$(echo "$APP_ENV");
echo "Deploying $APP_ENV..........";

if [ "$APP_ENV" == "local" ]
then
   cd ../docker &&
   docker-compose down;
else
    echo 'To pause production do it on Arvan panel';
fi