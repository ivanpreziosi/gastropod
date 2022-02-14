<?php


use Illuminate\Support\Facades\Route;
use RadFic\Gastropod\Http\Controllers\GastropodController;
use RadFic\Gastropod\Http\Controllers\UserCrudController;





Route::prefix('gastropod')->group(['middleware' => ['web']],function () {
    Route::get('/', [GastropodController::class,'getLogin']);

    Route::get('/login', [GastropodController::class,'getLogin']);
    Route::post('/login', [GastropodController::class,'doLogin']);
    Route::get('/logout', [GastropodController::class,'logout']);

    //Route::middleware(['gastropodAuth'])->group(function () {
        Route::resources([
            'users' => 'RadFic\Gastropod\Http\Controllers\UserCrudController',
        ]);
    //});
});
