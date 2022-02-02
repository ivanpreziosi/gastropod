<?php

namespace RadFic\Gastropod\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Profile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CrudUserController extends BaseCrudTableController
{
    public function __construct()
    {
        /** set class   **/
        $this->class = User::class;//declare the class of the eloquent instances
        /** don't touch **/
        $item = new $this->class();//a eloquent instance
        Parent::__construct($item);
        
        $this->relationsMap($item);
    }

    public function relationsMap($item)
    {
		//load required relations
        $item->profile;
        Parent::getRelations($item);
		//define relations map
        $this->relationsMap = [
            'profile' => [
                'key' => "profile_id",
                'field' => 'name',
                'model' => Profile::class
            ]
        ];
    }
}
