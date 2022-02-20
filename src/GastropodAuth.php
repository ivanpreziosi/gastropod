<?php

namespace RadFic\Gastropod;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GastropodAuth
{
    /**
     * Check if logged user is a gastronaut
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public static function check()
    {
        if (!config('gastropod.enable_gastropod_auth')) {
            return true;
        }

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
