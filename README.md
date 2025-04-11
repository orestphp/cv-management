# Nuxt - Laravel

## Technologies Used

   - FROM node:20.9.0-alpine
   - FROM mysql:8.0
   - FROM php:8.1.8-fpm-buster
   - FROM nginx:1.18-alpine
   - Nuxt2/Vue2
   - Laravel 9
   - xdebug 2

## Install

After 'git clone', inside repo:
```
$ make init
```
```
$ make up
```

NOTE: If you get "php artisan migrate" error, just do it manualy:
```
docker-compose exec app php artisan migrate:fresh --seed
```

### frontend
http://127.0.0.1:3000/

### api
http://localhost:8001/

### phpmyadmin
http://127.0.0.1:8081/
   - `user`
   - `password`

## Development

Password can be created/changed via Tinker:
   - `docker exec -it <container ID> php artisan tinker`
   - `$user = App\Models\User::where('email', 'admin@admin.com')->first();`
   - `$user->password = Hash::make('pass');`
   - `$user->save();`

NOTE: In this version 2, user can be created via Tinker only

## Command Glossary

   - `make down`
   - `make up`
   - `make dev`
   - `docker ps` - list all running containers
   - `docker exec -it <container_id> sh` - Enter container
   - `docker logs -f <container_id>` - see incomming logs for container
