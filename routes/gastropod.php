<?php
use Illuminate\Support\Facades\Route;
use RadFic\Gastropod\Http\Controllers\GastropodController;

Route::get('/', [GastropodController::class,'getLogin']);
Route::get('/login', [GastropodController::class,'getLogin']);
Route::post('/login', [GastropodController::class,'doLogin']);
Route::get('/logout', [GastropodController::class,'logout']);