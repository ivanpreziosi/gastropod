<?php

namespace RadFic\Gastropod\Http\Controllers;

use RadFic\Gastropod\GastropodAuth\GastropodLoginCredential;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Admin;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * This is the main controller taking care of login and logout operations on Gastropod.
 */
class GastropodController extends Controller
{
    public function getLogin()
    {
        $data = [];
        return view('gastropod.login', $data);
    }

    public function doLogin(Request $request)
    {
        //validation
        $validator = Validator::make(request()->all(), [
            "email" => ['required', 'string', 'email', 'max:255'],
            "password" => ["required","min:8"],
        ]);

        if ($validator->fails()) {
            return back()->withInput();
        }

        $credentials = array();
        $credentials = array(
            'email' => $request->input('email'),
            'password' => $request->input('password')
        );


        foreach(config('gastropod.gastropod_login_credentials') as $loginCredentialName => $loginCredentialData){
            $credentialValue = null;
            switch($loginCredentialData->type){
                case GastropodLoginCredential::INPUT_REQUEST:
                    $credentialValue = $request->input($loginCredentialData->key);
                    break;
            }
             $credentials[$loginCredentialName] = $credentialValue;
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect(config('gastropod.default_page'));
        } else {
            return back()->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('gastropod/login');
    }
}
