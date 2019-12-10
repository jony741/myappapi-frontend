# myappapi

after cloning the project run: 
```sh
$ composer install
```
make sure .env file is exist then make sure to have these values:
```
APP_URL=http://127.0.0.1:8000
```

if you are working on mac and mamp:
```
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
DB_USERNAME=root
DB_PASSWORD=root
```

in config/database file: in mysql array make sure to have:
```
'unix_socket' => env('DB_SOCKET', ''), //under password
```

make sure that the database table exists in phpmyadmin
then run: 
```sh
php artisan migrate
```

to get passport authentication to work make sure keys are set:
```sh
php artisan passport:install
```

to access storage file:
```sh
php artisan storage:link
```

Nova Login Permissions
```
https://stackoverflow.com/questions/55546701/laravel-nova-only-access-from-specific-guard
```


# Common Knowledge

to clear config cache:
```
php artisan config:cache
```

Switch to the branch "issue1" by doing the following.
```sh
$ git checkout issue1
Switched to branch 'issue1'
```