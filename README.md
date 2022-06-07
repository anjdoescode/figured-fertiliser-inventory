# Fertiliser Inventory

This is a simple Laravel application built to handle stock requests from a Fertiliser Inventory. It works simply in a way that helps a user understand how much stock is available for use and how much the requested quantity costs.

## Getting Started
This project runs with Laravel v9.16 and PHP (>= 8.0.0).

To run it without local dependencies, use [Docker](#application-build-using-docker). The application utilises [Laravel Sail](https://laravel.com/docs/9.x/sail#installation) and has the necessary configurations.

### Application Build
After cloning the repository, get into project directory and run:

``` bash
# create .env file and do not forget to set your DB_PASSWORD
cp .env.example .env

# install composer
docker run -v $(pwd):/app composer install

# start sail
./vendor/bin/sail up -d

# set sail alias
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

# generate application key
sail artisan key:generate

# build CSS and JS assets
sail npm install
sail npm run dev
```

### Database Setup

Run database migrations and populate the database with existing inventory movements records.

``` bash
# migrate
sail artisan migrate

# seed
sail artisan db:seed
```

### Application Run
Go to http://localhost in order to see the application running.

## Code Overview

### Dependencies

- [Laravel Sail](https://vehikl.com/) - running the project using Docker
- [laravel/ui](https://github.com/laravel/ui) - generate basic bootstrap scaffolding

### Folders

- `app/Http/Controllers` - Contains all controllers
- `app/Http/Requests` - Contains all form requests
- `app/Http/Services` - Contains all files implementing services
- `database/migrations` - Contains all the database migrations
- `database/seeders` - Contains all the database seeders
- `resources` - Contains all the resources that are to be compiled
- `routes` - Contains all routes
- `tests/Unit` - Contains all unit tests

## Testing

To run tests, run this command:

```
sail artisan test
```

## Project Status

This project was made only for the purpose of complying to a coding assessment whith a mission to write a Laravel application that helps a user understand how much quantity of a product is available for use.  

## License

Copyright © 2022 [@anjdoescode](https://github.com/anjdoescode) <br>
This project is [MIT](https://opensource.org/licenses/MIT) licensed.

