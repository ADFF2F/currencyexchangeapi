# Currencies Exchange API


[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![Minimum Symfony Version](https://img.shields.io/badge/Symfony-%3E%3D%204.4-f5c542.svg)](https://php.net/)

 
### Installation

```bash
git clone https://github.com/ADFF2F/currencyexchangeapi.git

cd currencyexchangeapi && composer install
```
Set DATABASE_URL parameter in .env and .env.test according to your database 

Create database and execute migrations:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
Start symfony server in the background:
```bash
symfony server:start -d
```
Insert initial data:
```bash
bin/console exchange-api:insert-initial-data 
```
### Usage
```text
GET /currencies
Return list of available currencies

GET /currencies/{currency}
Return available exchange rates
Parameters:
currency: 3 letter currency code ISO 4217 e.g. PLN, USD, EUR

GET /currencies/convert
Return converted value
GET Parameteres: 
from: (required) 3 letter currency code ISO 4217
to: (required) 3 letter currency code ISO 4217
amount: (required) positive integer representing how much to exchange in the smallest currency unit (e.g. 100 cents to exchange $1.00) 
```
 
### Testing

```php
./bin/phpunit
```