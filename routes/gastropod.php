<?php
use Illuminate\Support\Facades\Route;
use RadFic\Gastropod\Http\Controllers\GastropodController;
use RadFic\Gastropod\Http\Controllers\UserCrudController;
use RadFic\Gastropod\Http\Controllers\AdminCrudController;

Route::prefix('gastropod')->middleware(['web'])->group(function () {
    Route::get('/', [GastropodController::class,'getLogin']);

    Route::get('/login', [GastropodController::class,'getLogin']);
    Route::post('/login', [GastropodController::class,'doLogin']);
    Route::get('/logout', [GastropodController::class,'logout']);

    Route::middleware(['gastropodAuth'])->group(function () {
        /**
         * Default routes: admin and users
         */
        Route::resources([
            'users' => 'RadFic\Gastropod\Http\Controllers\UserCrudController',
            'admins' => 'RadFic\Gastropod\Http\Controllers\AdminCrudController',
        ]);
    });
});