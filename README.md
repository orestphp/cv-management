# Nuxt - Laravel

## Usage

```
$ make init
$ make dev
```

### nuxt

http://127.0.0.1:3000/

### api

http://127.0.0.1:8001/

### phpmyadmin

http://127.0.0.1:8081/

## Development

1. There are two options to run "frontend" in "front" container:
   1) Using `make dev`
   2) `docker-compose down` and out of container, if you need console messages and to see runtime errors/warnings)
   - `cd /var/www/rms/frontend`
   - `npm run dev` (for convenient console use)
   Then in new terminal:
   - `cd /var/www/rms/`
   - `docker-compose up -d`
     - ignore: Creating rms_front_1 ... error
2. Access: 
   - http://localhost:3000
   - admin@admin.com
   - password
3. Password can be changed via User Profile or via Tinker:
   - `docker exec -it <container ID> php artisan tinker`
   - `$user = App\User::where('email', 'admin@admin.com')->first();`
   - `$user->password = Hash::make('pass');`
   - `$user->save();`
