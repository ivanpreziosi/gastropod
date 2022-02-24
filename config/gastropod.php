<?php

return [

    /**
     * This is the name that will appear in the upper left navbar.
     */
    'name' => '••G@STROPOD••',

    /**
     * This is the default page that Gastropod will open after login, like a sort of dashboard.
     * Usually i set it to the Users Crud Page.
     */
    'default_page' => '/gastropod/gastropod_admins',

    /**
     * WARNING:
     * If set to false will leave the crud open to the public!
     */
    'enable_gastropod_auth' => true,  
    
    /**
     * Credentials needed to login. Gastropod will attempt to login your users calling
     * Laravel Illuminate\Support\Facades\Auth::attempt($credentials) and then
     * checking on the `gastropod_admins` table to see if the user is a valid gastronaut.
     * Here you can specify which properties of your User model you want to attempt authentication on. 
     */
    'gastropod_login_credentials' => [
        'email' => new \RadFic\Gastropod\GastropodAuth\GastropodLoginCredential(\RadFic\Gastropod\GastropodAuth\GastropodLoginCredential::INPUT_REQUEST,'email'),
        'password' => new \RadFic\Gastropod\GastropodAuth\GastropodLoginCredential(\RadFic\Gastropod\GastropodAuth\GastropodLoginCredential::INPUT_REQUEST,'password'),
    ]
];
