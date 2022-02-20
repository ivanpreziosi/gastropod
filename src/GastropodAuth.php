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
    static function check()
    {
        if (!config('gastropod.enable_gastropod_auth')) {
            return;
        }

        if (!Auth::check()) {
            return redirect('/gastropod/login');
        }

        $user = Auth::user();

        if ($user == null) {
            return redirect('/gastropod/login');
        }
        $admin = DB::table('gastropod_admins')
                ->where('user_id', '=', $user->id)
                ->first();

        if ($admin == null) {
            return redirect('/gastropod/login');
        }

        Auth::user()->gastronaut = true;
    }
}
