<?php

namespace RadFic\Gastropod\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


use App\Models\Admin;
use App\Models\User;

class CrudAdminController extends BaseCrudTableController
{
    public function __construct()
    {
        /** set class  *************** */
        $this->class = Admin::class;
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
