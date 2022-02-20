<?php

namespace RadFic\Gastropod\Http\Controllers;

use RadFic\Gastropod\Http\Controllers\GastropodCrudController;

//Needed models
use App\Models\User;
use App\Models\GastropodAdmin;

class GastropodAdminController extends GastropodCrudController
{
    public function __construct()
    {
        //set model for this crud
        $this->model = GastropodAdmin::class;
        //define relations map
        $this->relationsMap = [
            'profile' => [
                'key' => "user_id",
                'field' => 'email',
                'model' => User::class
            ]
        ];
        parent::__construct();
    }
}
