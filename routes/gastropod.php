<?php
use Illuminate\Support\Facades\Route;
use RadFic\Gastropod\Http\Controllers\GastropodController;

/** 
 * Gastropod Routes
 */
Route::middleware('web')->group(function () {
	/** service routes */
    Route::get('/', [GastropodController::class,'getLogin']);
    Route::get('/login', [GastropodController::class,'getLogin']);
    Route::post('/login', [GastropodController::class,'doLogin']);
    Route::get('/logout', [GastropodController::class,'logout']);

	/** resource routes */
	Route::resources([
		/**
		 * gastropod_admins is installed by default: it manages the crud admin permissions on app users. 
		 */
        'gastropod_admins' => 'RadFic\Gastropod\Http\Controllers\GastropodAdminController'
    ]);

});
