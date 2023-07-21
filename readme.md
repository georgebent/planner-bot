# Planner

## Requirements

- Docker
- Docker-compose
- Php [8.2]
- Symfony [6.3]

## Installation

After download run:
```sh
docker-compose up --build

#in php container:
composer install 
php bin/console doctrine:migrations:migrate
```

##### Rename .env.example to .env

## Configuration

In .env file you must enter:
- ip of containers
- database settings

## Troubleshooting & FAQ

- [Problem] - [Solution]