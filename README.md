<div style="width:100%;text-align:center;border:3px solid grey;"><img src="/resources/assets/img/gastropod.jpg" title="gastropod" style="width:50%;margin:auto;"></div>

Gastropod a simple Laravel package intended to speed up and ease the creation of crud based admin tables for small websites.

**PLEASE NOTE THAT GASTROPOD IS STILL IN DEVELOPMENT PHASE, PACKAGE IS NOT UPLOADED TO PACKAGIST OR ANY SIMILAR SERVICE**


# Install
You can install the package using composer:
```
composer require radfic/gastropod
```

## Publish all gastropod files:
```
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider"
```
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
After publishng a new migration will be present in your app's migrations folder: "2022_02_13_172741create_gastropod_admins_table.php"

It defines a new table in your database to hold reference to users allowed to access gastropod.

Now you should run your migrations to let artisan create the Admins table for you:
```
php artisan migrate
```

After running your migrations you should have a new table in your db: 'gastropod_admins'.
```
|----------------------------------------|
| gastropod_admins                       |
|----------------------------------------|
| id | user_id | created_at | updated_at |
|----|---------|------------|------------|
```

## Create First Admin
Manually add an admin inserting a row referencing a users table row.
