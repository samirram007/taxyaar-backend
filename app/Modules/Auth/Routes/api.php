<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\Api\AuthController;

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    //google routes
    Route::post('/google/login', [AuthController::class, 'googleLogin']);
    Route::post('/test/google/login', [AuthController::class, 'testGoogleLogin']);
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('jwt.cookies');
});
Route::middleware(['jwt.cookies'])->group(function () {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'profile']);
        Route::get('/user', [AuthController::class, 'profile']);
    });
});