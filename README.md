

## Vom Task

### System Requirements
- php 7.4 or above
- apache
- mysql

### Installation steps
 **Run the following commands**
- composer install
- set .env file and set database credentials
- php artisan migrate --seed
- php artisan key:generate
- php artisan jwt:secret

APIs documentation link: 
https://documenter.getpostman.com/view/3446458/2s847BTvcd

**Project Scenario and steps:**
- register as new merchant with store details
- login to new account
- set store settings from update store settings
- add many products
- list all products as customer with en ot ar lang.
- add multi products to cart and get total price

**External packages used:**
- laravel translatable: https://github.com/spatie/laravel-translatable
- JWT: https://github.com/tymondesigns/jwt-auth
