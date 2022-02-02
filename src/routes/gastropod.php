<?php
Route::prefix('gastropod')->group(function () {
    Route::get('/', [Gastropod\Controllers\GastropodController::class,'getLogin']);

    Route::get('/login', [Gastropod\Controllers\GastropodController::class,'getLogin']);
    Route::post('/login', [Gastropod\Controllers\GastropodController::class,'doLogin']);
    Route::get('/logout', [Gastropod\Controllers\GastropodController::class,'logout']);

    Route::middleware(['gastropodAuth'])->group(function () {
        Route::resources([
            'users' => 'Gastropod\Controllers\UserCrudController',
        ]);
    });
});
