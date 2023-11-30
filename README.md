# How to use it?
#### Run docker container
###### 
```
docker-compose up --build -d
```
#### Connect to app container
```
docker exec -it app-php-fpm /bin/sh
```
#### Run composer install
```
composer install
```
#### Copy .env
```
cp .env.example .env
```
#### Generate key
```
php artisan key:generate
```
#### Run migration and seed
```
php artisan migrate --seed
```
