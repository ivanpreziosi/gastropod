<?php

namespace RadFic\Gastropod\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Models\Admin;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class GastropodController extends Controller
{
    public function getLogin()
    {
        $data = [];
        return view('admin.login', $data);
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

        $credentials = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'confirm_token' => null,
        );
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('gastropod/users');
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
