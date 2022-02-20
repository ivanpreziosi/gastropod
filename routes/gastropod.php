<?php
use Illuminate\Support\Facades\Route;
use RadFic\Gastropod\Http\Controllers\GastropodController;

Route::prefix('gastropod')->middleware('web')->group(function () {
    Route::get('/', [GastropodController::class,'getLogin']);
    Route::get('/login', [GastropodController::class,'getLogin']);
    Route::post('/login', [GastropodController::class,'doLogin']);
    Route::get('/logout', [GastropodController::class,'logout']);

	Route::resources([
        'users' => 'App\Http\Controllers\Gastropod\UserGastropodController',
        'gastropod_admins' => 'RadFic\Gastropod\Http\Controllers\GastropodAdminController'
    ]);

});
