<?php

namespace RadFic\Gastropod\Http\Controllers;

use RadFic\Gastropod\Http\Controllers\GastropodCrudController;

/** We need to import the models we will need later on. */
use App\Models\User;
use App\Models\GastropodAdmin;

/**
 * GastropodAdminController
 *
 * This is just a default crud that Gastropod creates on install.
 * It uses the default table `gastropod_admins` created by the migration Gastropod publishes on install.
 * It also uses the default model `App\Models\GastropodAdmin` published by Gastropod on install.
 * It can be also a small example to see how to configure a basic crud.
 * 
 * It must extend RadFic\Gastropod\Http\Controllers\GastropodCrudController.
 */
class GastropodAdminController extends GastropodCrudController
{
	/**
	 * In the constructor we do all needed configuration for the resource crud.
	 */
    public function __construct()
    {
        /**
         * The Eloquent model we want to crud.
         */
        $model = GastropodAdmin::class;
        
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
            'user' => [
                'key' => "user_id",
                'field' => 'email',
                'model' => User::class
            ]
        ];

		/**
		 * After setup we call GastropodCrudController's constructor 
		 * to take care of the init job.
		 */
        parent::__construct($model,$relationsMap);
    }
}
