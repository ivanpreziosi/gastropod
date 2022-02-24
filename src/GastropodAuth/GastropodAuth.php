<?php

namespace RadFic\Gastropod\GastropodAuth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * GastropodAuth is the class in charge of checking if logged users are also allowed
 * to browse the Gastropod area.
 */
class GastropodAuth
{
    /**
     * Check if logged user is a gastronaut
     *
     * @return bool
     */
    public static function check()
    {
        /** if disabled skip any check */
        if (!config('gastropod.enable_gastropod_auth')) {
            return true;
        }

        /** check if user is currently logged */
        if (!Auth::check()) {
            return false;
        }
           
        $user = Auth::user();

        if ($user == null) {
            return false;
        }
        
        $admin = DB::table('gastropod_admins')
                ->where('user_id', '=', $user->id)
                ->first();

        if ($admin == null) {
            return false;
        }

        Auth::user()->gastronaut = true;
        return true;
    }
}
