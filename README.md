# Trace Wallet App
Trace wallet APIs can be used to trace transactions and balance of any wallet on Ether, Binance and Polygon smartchains.

This is a single page application build with Laravel and Vue.js.
# Quick Installation
### Requirements
Composer, PHP 8.1 or greator

Clone or download the repository.
```sh
git clone https://github.com/mukul20/tracewallet.git
```
Switch to the repo folder
```sh
cd tracewallet
```
Install all the dependencies using composer
```sh
composer install
```
### Environment variables
Copy `.env.example` file to `.env` file 
```sh
cp .env.example .env
```
***
# Running Web Application
Use below artisan command to start the application
```sh
php artisan serve
```
Ideally application should get hosted on http://127.0.0.1:8000/
<br/>
In case it is hosted to some other port, make sure to update the same in APP_URL variable in .env file.

Open hosted url on your web browser.
***
# Consuming API's
To use it via API, follow API documentation here - [Postman Documentation](https://documenter.getpostman.com/view/665369/UVXjLGrg)
***
# Code overview
For better efficiency, this application uses cache to store and retreive API responses.

* `.env` - Environment variables can be set in this file.

### Folders

* `app/Http/Controllers/API/v1` - Contains all the API controllers
* `app/Http/Providers` - Contains smartchain service provider
* `app/Http/Services` - Contains smartchain services
* `config` - Contains all the application configuration files
* `routes/api/v1` - Contains all the api routes defined in api.php file
* `tests` - Contains all test cases for the application
* `tests/Feature` - Contains all the API tests
### Running Test Cases

```sh
vendor/bin/phpunit ./tests
```
or
```sh
php artisan test
```