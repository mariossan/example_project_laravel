# Example Laravel Projetc

This project is created with docker,PHP (Laravel), MySQL & NGINX and to run this correctly and easy has 2 posibilities to construct.

## First: using unique bash to execute
```
    $ bash start_project.sh
```

## Second: Follow this instruccions

### Copy el .env
```
    $ cp .env.example .env
```

### Ejecutando el proyecto
```
    $ docker-compose up --build -d
```

### Copy .env.example from Laravel project
```
    $ cp html/.env.example html/.env
```

### Execute composer and fill the database
```
    $ docker exec -ti example_project_php bash
    $ composer install
    $ php artisan migrate --seed
```

### change permissions to folders
```
    chown -R www-data:www-data storage bootstrap
    chmod -R 755 storage bootstrap
```

### Result
```
    http://localhost:5000
```

### Finally 
If you ca use all system, first you have to go to campaigns section and create one, then you have to click in eye icon to show more.