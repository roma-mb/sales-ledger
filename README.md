<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## Sales Ledger

API REST for manage sales.

### Backend

This is a description on how setup the project and import cities.

required:
```
"php": "^7.4|^8.0",
"friendsofphp/php-cs-fixer": "^3.2",
"laravel/framework": "^8.65",
```

#### .env

Copy .env.example and rename to .env.

#### Mysql

Create user

```
CREATE USER 'root'@'localhost' IDENTIFIED BY 'root';
GRANT ALL ON *.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
```

Create database

```
CREATE DATABASE sales_ledger
```

Update .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sales_ledger
DB_USERNAME=root
DB_PASSWORD=root
```

### Mail

Create account in mailtrap, update .env
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
```

#### Start Server

run
```
php artisan serve --port=8080
```

#### Migrations

run
```
php artisan migrate
```

#### Command to import Cities

* Description: Send email report with total sales daily.
* Usage: total-sale:send

Example:
``
php artisan total-sale:send
``

### Run tests
```
vendor/bin/phpunit
```

### Run cs-fixer
```
composer cs-fixer
```

### Postman
[Collection](https://www.postman.com/rom-mb/workspace/sales-ledger/collection/6885147-dfcd7c54-9ab3-4472-8866-ec7f8f996926)
