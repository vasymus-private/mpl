
# Laravel application

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

# Local deployment

## Installation

After cloning the repository run the command:
```shell
git submodule update --init --force docker
```

### First time

```shell
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

# run migrations
php artisan migrate

# seed data
SEEDERS_CLEAR_DATA=true php artisan db:seed

# install node_modules
npm install

# one-time build webpack
npm run dev
# or
# build and watch webpack
npm run watch

# to exit container
exit

# stop docker-compose when finish working
docker-compose down
```

### Git checkout

```shell
git submodule update --init --force docker

# build and run docker-compose
docker-compose up -d --build
# or
# without build (especially, when there were no changes in docker folder)
docker-compose up -d

# enter `app` container
docker-compose exec app bash

# run migrations with seeds
php artisan migrate --seed

# install node_modules
npm install

# one-time build webpack
npm run dev
# or
# build and watch webpack
npm run watch

# to exit container
exit

# stop docker-compose when finish working
docker-compose down
```

## Update of docker submodule

Do not update docker submodule until you know what to do.

Main git repo is connected with submodule only via hash. See explanation here https://stackoverflow.com/a/55570998.

If you update submodule files update hash of submodule should be push in the main repo. 

# CI/CD

## Manual Actions on hosting

Ssh to according hosting. Create separate user or use existing one (not `root`), for example, `developer` and add him to `docker` group.

```shell
sudo usermod -a -G docker developer
```

Install docker-compose according to [guid](https://docs.docker.com/compose/install/#install-compose-on-linux-systems).


# Inertia

## Server Side Rendering

Run build:
```shell
npx mix --mix-config=webpack.ssr.mix.js
# or
npm run ssr
```

Then run simple node server:
```shell
node public/_admin/js/ssr.js
```
temp5
some changes should be ignored
