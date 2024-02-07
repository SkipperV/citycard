# Citycard

Website to track user`s citycard expenses, managing citycard system (managing cities, transport and available tickets)

## Getting Started

### Dependencies

* Windows/MacOS/Linux with preinstalled Git (to use git clone) and Docker Engine

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
* Run migrations and seed database
```
docker exec citycard-app php artisan migrate --seed
```

## Authors

* [SkipperV](https://github.com/SkipperV)
