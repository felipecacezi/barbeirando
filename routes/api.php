<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;


Route::get('/user/{id}', [UserController::class, 'get']);
Route::post('/user/store', [UserController::class, 'store']);
Route::patch('/user/update/{id}', [UserController::class, 'update']);