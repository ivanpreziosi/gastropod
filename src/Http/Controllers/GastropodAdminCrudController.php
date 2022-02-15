<?php

namespace RadFic\Gastropod\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


use RadFic\Gastropod\Models\GastropodAdmin;
use App\Models\User;

class GastropodAdminCrudController extends BaseCrudTableController
{
    public function __construct()
    {
        /** set model  *************** */
        $this->class = GastropodAdmin::class;
        /***************************** */

        /** don't touch! *********/
        $item = new $this->class();
        Parent::__construct($item);        
        $this->relationsMap($item);
		/*********************** */
    }

    /**
     * declare relationships
     */
    public function relationsMap($item)
    {
        Parent::getRelations($item);
        $this->relationsMap = [
            'user' => [
                'key' => "user_id",
                'field' => 'email',
                'model' => User::class
            ]
        ];
    }
}
