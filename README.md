<p align="center">
  <img src="/resources/assets/img/gastropod.jpg" title="gastropod" style="width:25%!important;margin:auto;">
</p>

Gastropod a simple Laravel package intended to speed up and ease the creation of crud based admin pages for small websites. It assumes you already have a users table and a User Eloquent model to automatically create a simple Users and Admin crud. You can then further expand it to have it manage all of your tables, and you can setup a basic, yet expandable, crud system with very few lines of code. Gastropod views are created with [Bootstrap](https://getbootstrap.com/) and [jQuery](https://jquery.com/), and it pulls it's needed scripts and css from cdns without having you to do anything. Its Auth is based on existing Laravel Auth system, only adding a table to reference which users will be admitted to the crud. But users will still login against your own users table without having to modify it.

**PLEASE NOTE THAT GASTROPOD IS STILL IN PRE-ALPHA STAGE, USE IT FOR EXPERIMENT OR IF YOU WANT TO CONTRIBUTE BUT DON'T USE IT IN A PRODUCTION ENVIRONMENT.**


# Install
You can install the package using composer:
```
composer require radfic/gastropod
```

## Publish all Gastropod files:
```
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider"
```
Run this command to publish all the gastropod assets needed for the package to function.
It will create:
- migrations: a migration for a new table called `gastropod_admins` will be copied in your migrations folder (`database/migrations/`). This will create a new table in your db which will hold reference to the users allowed to browse and use gastropod. Check later the ["Run Migrations"](#run-migrations) paragraph for more infos.
- config: a config file will be created in your app's config folder: `config/gastropod.php`. 
- views: all the Gastropod crud related views will be located in `resources/views/radfic/gastropod/`.
- assets: all the css, javascripts and image files will be located in `public/gastropod/`.

### Manually publishing assets one by one:
You may want to republish or publish only some of the assets. You can do this by running the artisan vendor:publish command specifing a tag:
```
#migrations
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="migrations"
#config
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="config"
#views
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="views"
#assets
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="assets"
```

## Run Migrations
After publishng your assets, a new migration will be present in your app's migrations folder: `2022_02_13_172741_create_gastropod_admins_table.php`.
It defines a new table in your database to hold reference to users allowed to access gastropod.

Now you should run your migrations to let artisan create the table for you, by running the artisan migrate command:
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
Gastropod is assuming you have a users table and a User model in your app already. To let users use Gastropod you will have to add a record in this table per user, referencing the id of the user. The first Gastropod Admin has to be set with your own means (for example with PhpMyAdmin). Once Gastropo is installed you will add more admins using it's interface.

## Create First Admin
Manually add an admin inserting a new record referencing a users table row:
```
INSERT INTO `gastropod_admins` (`user_id`) VALUES (USER-ID-TO-MAKE-ADMIN);
```
This user will now be allowed to login into gastropod. Every further user you would like to give access to Gastropod should have a related record in this table.

## Check installation
Go to the `/gastropod` route to see if the login page is showing up. If it does you should login with the user related to [the record you inserted before](#create-first-admin) in the `gastropod_admins` table. If everything went fine you should see your users table now. And also a gastropod_admins table should be set up and accessible via the menu.
