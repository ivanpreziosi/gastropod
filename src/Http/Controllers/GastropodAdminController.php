<?php

namespace RadFic\Gastropod\Http\Controllers;

use RadFic\Gastropod\Http\Controllers\GastropodCrudController;

/** We need to import the models we will need later on. */
use App\Models\User;
use App\Models\GastropodAdmin;
use RadFic\Gastropod\GastropodRelation;


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
		 * `name` is the relationship name as is mapped in the Model
		 * `model` is the Eloquent model of the referenced table.
		 * `field` is the name of the field we want to show in our crud from the related table.
		 * `key` is the name of the field holding reference to the other class id.
		 * `type` is the relation type: see in RadFic\Gastropod\GastropodRelation.
		 */
        $relationsMap[] = GastropodRelation::create(
			'user',							//the relationship name as is mapped in the Model
			User::class,					//the Eloquent model of the referenced table
			'email',						//the name of the field we want to show in our crud
			'user_id',						//is the name of the field holding reference to the other class id
			GastropodRelation::TYPE_11		//the relation type: see in RadFic\Gastropod\GastropodRelation
		);

		/**
		 * After setup we call GastropodCrudController's constructor 
		 * to take care of the init job.
		 * No need to touch this part.
		 */
        parent::__construct($model,$relationsMap);
    }
}
