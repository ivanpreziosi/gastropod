<?php
use Illuminate\Support\Facades\Route;
use RadFic\Gastropod\Http\Controllers\GastropodController;
use RadFic\Gastropod\Http\Controllers\UserCrudController;
use RadFic\Gastropod\Http\Controllers\GastropodAdminCrudController;

Route::get('/gastropod', [GastropodController::class,'getLogin']);
Route::prefix('gastropod')->middleware(['web'])->group(function () {
    Route::get('/login', [GastropodController::class,'getLogin']);
    Route::post('/login', [GastropodController::class,'doLogin']);
    Route::get('/logout', [GastropodController::class,'logout']);
    Route::middleware(['gastropodAuth'])->group(function () {
        /**
         * Map here your resources to the appropriate controller
         * extending RadFic\Gastropod\Http\Controllers\BaseCrudTableController
         * 
         * Default routes: admin and users are precreated. Feel free to 
         * inspect them and modify them to suit your needs.
         */
        Route::resources([
            'users' => 'RadFic\Gastropod\Http\Controllers\UserCrudController',
            'gastropod_admins' => 'RadFic\Gastropod\Http\Controllers\GastropodAdminCrudController',
        ]);
    });
});