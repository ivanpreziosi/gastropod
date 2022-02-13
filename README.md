# gastropod v.0.0.1


Gastropod a simple Laravel package intended to speed up and ease the creation of crud based admin tables for small websites.

**PLEASE NOTE THAT GASTROPOD IS STILL IN DEVELOPMENT PHASE, PACKAGE IS NOT UPLOADED TO PACKAGIST OR ANY SIMILAR SERVICE**

Install:
composer require radfic/gastropod

Publish migrations:
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="migrations"

After this command a new migration will be copied in your app's migrations folder: 2022_02_13_172741create_gastropod_admins_table.php

Now you should run your migrations to let artisan create the Admins table for you:
php artisan migrate


After that publish gastropod views:
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="views"

And gastropod assets as well:
php artisan vendor:publish --provider="RadFic\Gastropod\GastropodServiceProvider" --tag="assets"

