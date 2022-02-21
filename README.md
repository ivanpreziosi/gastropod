**PLEASE NOTE THAT GASTROPOD IS STILL IN PRE-ALPHA STAGE, USE IT FOR EXPERIMENT OR IF YOU WANT TO CONTRIBUTE BUT DON'T USE IT IN A PRODUCTION ENVIRONMENT.**

<p align="center">
  <img src="/resources/assets/img/gastropod.jpg" title="gastropod" style="width:25%!important;margin:auto;">
</p>

Gastropod a simple Laravel package intended to speed up and ease the creation of crud based admin pages for small websites. It assumes you already have a users table and a User Eloquent model to automatically create a simple Users and Admin crud. You can then further expand it to have it manage all of your tables, and you can setup a basic, yet expandable, crud system with very few lines of code. Gastropod views are created with [Bootstrap](https://getbootstrap.com/) and [jQuery](https://jquery.com/), and it pulls it's needed scripts and css from cdns without having you to do anything. Its Auth is based on existing Laravel Auth system, only adding a table to reference which users will be admitted to the crud. But users will still login against your own users table without having to modify it.

# 1)Install from composer
You can install the package using composer:
```
composer require radfic/gastropod
```
# 2)Run the artisan install script
After that you will have to run the `gastropod:install` artisan command:
```
php artisan gastropod:install
```
It will publish a number of files in your app's directory structure:
```
--App
  --Models
    --GastropodAdmin.php //It's the default model which Gastropod will use to authenticate users.
--config
  --gastropod.php //Will hold all configuration parameters of Gastropod.
--database
  --migrations
    --2022_02_14_000001_create_gastropod_admins_table.php //a migration which will create the gastropod_admins table in your db.
--public
  --gastropod_assets //will contain all required Gastropod assets: images, css, js and such.
--resources
  --views
    -gastropod //will contain all Gastropod related views.
--routes
  --gastropod.php //a routes file to hols all Gastropod related routes.
```

# 3)Run Migrations
After publishng your assets, a new migration will be present in your app's migrations folder: `2022_02_13_172741_create_gastropod_admins_table.php`.
It defines a new table in your database to hold reference to users allowed to access gastropod.

3)Now you should run your migrations to let artisan create the table for you, by running the artisan migrate command:
```
php artisan migrate
```

After running your migrations you should have a new table in your db: 'gastropod_admins'.
```sql
|----------------------------------------|
| gastropod_admins                       |
|----------------------------------------|
| id | user_id | created_at | updated_at |
|----|---------|------------|------------|
```
Gastropod is assuming you have a users table and a User model in your app already. To let users use Gastropod you will have to add a record in this table per user, referencing the id of the user. The first Gastropod Admin has to be set with your own means (for example with PhpMyAdmin). Once Gastropo is installed you will add more admins using it's interface.

## 3.1)Create First Admin
Manually add a first admin inserting a new record in `gastropod_admins`, referencing a users table row:
```sql
INSERT INTO `gastropod_admins` (`user_id`) VALUES (USER-ID-TO-MAKE-ADMIN);
```
This user will now be allowed to login into gastropod. Every further user you would like to give access to Gastropod should have a related record in this table.

# 4)Register Gastropod Routes in RouteServiceProvider
Last step is registering gastropod routes into your app's RouteServiceProvider. To do this open the file `app\Providers\RouteServiceProvider.php` and add the gastropod bit after all other entries in the boot function:
```php
public function boot()
{
    $this->routes(function () {
    
      /** [... YOUR OTHER ROUTE GROUPS: web, api, ecc ..] */
      
      //G@STROPOD ROUTES->copy in your RouteServiceProvider
      Route::prefix('gastropod')
          ->middleware('web')
          ->namespace($this->namespace)
          ->group(base_path('routes/gastropod.php'));
      //END of G@STROPOD ROUTES
      
    });
}

```

# Finished: check your installation!
Go to the `/gastropod` route to see if the login page is showing up. If it does you should login with the user related to [the record you inserted before](#create-first-admin) in the `gastropod_admins` table. If everything went fine you should see your users table now. And also a gastropod_admins table should be set up and accessible via the menu.

# Create your first gastropod crud
If your Gastropod is up and running next thing you want to know is how to add models to the crud.
So lets begin with an example created from a real life scenario: you want to add a `users` table. Gastropod is always assuming that you already have your tables set up and your models, with all relevant relations defined, in place before you try to create a new crud, so lets assume we have already our tables and models: a `users` table and a `User` model.
Lets start by using the custom artisan `make:gastropodController` command. It will need two parameters:
- The name of the Controller you will create, for users controller i would suggest something like: `Gastropod\GastropodUserController`. Please note that this way the controller class file will be created in the Gastropod Folder under your `app/Http/Controllers` folder.
- The name of the model you want to crud. In this example we want to crud the User model.
```
php artisan make:gastropodController Gastropod\GastropodUserController User
```
After that you will have a brand new Gastropod controller in your App. Check it out sinche you may want to modify it:
```php
<?php

namespace App\Http\Controllers\Gastropod;
use RadFic\Gastropod\Http\Controllers\GastropodCrudController;

/** We need to import the models we will need later on. */
use App\Models\User;

/**
 * GastropodUserController
 * 
 * It must extend RadFic\Gastropod\Http\Controllers\GastropodCrudController.
 */
class GastropodUserController extends GastropodCrudController
{
	/**
	 * In the constructor we do all needed configuration for the resource crud.
	 */
    public function __construct()
    {
        /**
         * The Eloquent model we want to crud.
         */
        $model = User::class;
        
		/**
		 * Relations map is a map of all relations we want our crud to take care of.
		 * `key` is the name of the field holding reference to the other class id.
		 * `field` is the name of the field we want to show in our crud from the related table.
		 * `model` is the Eloquent model of the referenced table.
		 */
        $relationsMap = [
			/**
			 * We define this default relationship using gastropod_admins 
			 * table's `user` relationship.
			 */	

			 /* Example:
			 'profile' => [
                'key' => "profile_id",
                'field' => 'name',
                'model' => Profile::class  //always remember to import the other model as well, using `use`
             ]
			*/		
        ];

		/**
		 * After setup we call GastropodCrudController's constructor 
		 * to take care of the init job.
		 */
        parent::__construct($model,$relationsMap);
    }
}
```
Since our User model doesen't have relations to be considered our controller is ready as is. Now we just need to add the resource in our `routes/gastropod.php` file:
```php
  /** resource routes */
  Route::resources([
    /**
    * gastropod_admins is installed by default: it manages the crud admin permissions on app users. 
    */
    'gastropod_admins' => 'RadFic\Gastropod\Http\Controllers\GastropodAdminController',
    /** Our brand new resource: Users */
    'users' => 'App\Http\Controllers\Gastropod\GastropodUserController',
  ]);
```
There we will add a `user` entry after the default `gastropod_admins` entry. This will register all the relevant resource routes for our crud. Now we just have to test it out.
Point your browser to the route `gastropod/users` and you should be presented with the right crud.

Last thing you may want to do is update the Gastropod template view to add the user link to the navigation menu. So open the file `resources\views\gastropod\template.blade.php` and modify its nav bar as follows:
```html
<li class="nav-item">
  <a class="nav-link" aria-current="page" href="{{url('gastropod/users')}}">Users</a>
</li>
```
That's it. Happy Gastropoding!
