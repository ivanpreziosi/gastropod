<?php

return [
    /**
     * Set to false to leave the crud open to the public!
     */
    'enable_gastropod_auth' => true,
    
    
    /**
     * Gastropod resources to build admin routes
     */
    'resurces' => [
        'users' => 'RadFic\Gastropod\Http\Controllers\UserCrudController',
        'admins' => 'RadFic\Gastropod\Http\Controllers\AdminCrudController',
    ]
];
