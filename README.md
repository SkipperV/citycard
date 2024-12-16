# Citycard

Website to track user`s citycard expenses, managing citycard system (managing cities, transport and available tickets)

## Getting Started

### Dependencies

* Windows/macOS/Linux with preinstalled Git (to use git clone), Docker Engine and Node with npm.

### Installing

* Clone Git repository
```
git clone git@github.com:SkipperV/citycard.git
```
* Copy .env.example to .env


* Run docker-compose
```
docker-compose up --build -d
```
* Resolve and install Composer dependencies in docker container
```
docker exec citycard-app composer install
```
Elasticsearch container may take some time to fully initialize after startup, even though it appears to be in the 
"running" state. During this period, Elasticsearch may be under heavy load as it performs operations like index creation
and shard allocation.

Please follow these steps before proceeding with further commands:

1. Wait for the container to finish initializing.
2. Monitor the CPU usage of the Elasticsearch container using command ```docker stats``` or similar tools.
3. Ensure the CPU usage is low and stable before running commands that interact with Elasticsearch and database.
* Create Elasticsearch cities index
```
docker exec citycard-app search:create-cities-index
```
* Run migrations and seed database
```
docker exec citycard-app php artisan migrate --seed
```
* Run npm build to build frontend components
```
npm run build
```

## Link to access running application

[localhost:8080](http://localhost:8080/)

## Link to access Swagger API documentation

[localhost:8080/api/documentation](http://localhost:8080/api/documentation)

## Author

* [SkipperV](https://github.com/SkipperV)
