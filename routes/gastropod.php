<?php
use Illuminate\Support\Facades\Route;
use RadFic\Gastropod\Http\Controllers\GastropodController;

Route::get('/gastropod', [GastropodController::class,'getLogin']);
Route::get('/gastropod/login', [GastropodController::class,'getLogin']);
Route::post('/gastropod/login', [GastropodController::class,'doLogin']);
Route::get('/gastropod/logout', [GastropodController::class,'logout']);