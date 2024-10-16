<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServerRecipeController;
use App\Http\Controllers\UserRecipeController;


Route::group([
    'prefix' => 'v1',
    'middleware' => 'with_fast_api_key'
], function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    Route::get('/serverrecipe', [ServerRecipeController::class, 'index']);
    Route::get('/serverrecipe/{id}', [ServerRecipeController::class, 'show']);

    Route::get('/userrecipe/{user_id}', [UserRecipeController::class, 'index']);
    Route::post('/userrecipe', [UserRecipeController::class, 'store']);
    Route::get('/userrecipe/{user_id}/{id}', [UserRecipeController::class, 'show']);
    Route::put('/userrecipe/{id}', [UserRecipeController::class, 'update']);
    Route::delete('/userrecipe/{id}', [UserRecipeController::class, 'destroy']);
});

