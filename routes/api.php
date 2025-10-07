<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::post('reload', function () {
    Artisan::call('migrate:refresh --seed');
});
Route::middleware(['jwt.cookies'])->group(function () {
    Route::post('reload', function () {
        Artisan::call('migrate:refresh --seed');
    });
});
