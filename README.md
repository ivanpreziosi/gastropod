# gastropod v.0.0.1


Gastropod a simple Laravel package intended to speed up and ease the creation of crud based admin tables for small websites.

**PLEASE NOTE THAT GASTROPOD IS STILL IN DEVELOPMENT PHASE, PACKAGE IS NOT UPLOADED TO PACKAGIST OR ANY SIMILAR SERVICE**

# Install
You can install the package using composer:
```composer require radfic/gastropod```

## Publish all gastropod files:
```php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider"```

This is equivalent to publishing the single tags one by one:
### migrations:
```php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="migrations"```
### config file:
```php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="config"```
### gastropod views:
```php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="views"```
### assets:
```php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="assets"```


## Run Migrations
After publishng a new migration will be present in your app's migrations folder: 2022_02_13_172741create_gastropod_admins_table.php
It defines a new table in your database to hold reference to users allowed to access gastropod.

Now you should run your migrations to let artisan create the Admins table for you:
```php artisan migrate```
