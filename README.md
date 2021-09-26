# Laravel application

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

# Local deployment

## First time
```shell
# clone repo
git clone --depth 1 -b mpl https://github.com/vasymus/docker.git docker

# create .env file
cp ./.env.example ./.env

# build and run docker-compose
docker-compose up -d --build

# enter `app` container
docker-compose exec app bash

# install php dependencies
composer install

# generate APP_KEY in .env
php artisan key:generate

# create link between ./storage/app/public and ./public/storage
php artisan storage:link

# run migrations with seeds
php artisan migrate --seed

# install node_modules
yarn

# one-time build webpack
yarn dev
# or
# build and watch webpack
yarn watch

# to exit container
exit

# stop docker-compose
docker-compose down
```

## All following application running
```shell
# do not rebuild
docker-compose up -d

# enter `app` container
docker-compose exec app bash

# build and watch webpack
yarn watch

# to exit container
exit

# stop docker-compose
docker-compose down
```
