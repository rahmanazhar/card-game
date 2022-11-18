## About This App

This app demonstrates how playing cards will be given out to n(number) people. Total 52 cards containing 1-13 of each Spade(S), Heart(H), Diamond(D), Club(C) will be given to n people randomly

Developed in Laravel 9.19.

## Run This App 

Run this app using Docker

1. Build the docker container
```
docker-compose build app
```

2. Running the docker
```
docker-compose up -d
```

3. Rebuilding the env and vendor package files
```
docker-compose exec app rm -rf vendor composer.lock
```
```
docker-compose exec app composer install
```
```
docker-compose exec app php artisan key:generate
```

4. Now go to your browser and access your server’s domain name or IP address on port 8000:

http://server_domain_or_IP:8000
