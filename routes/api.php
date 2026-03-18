<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\EnumController;

Route::post('reload', function () {
    Artisan::call('migrate:refresh --seed');
});
Route::middleware(['jwt.cookies'])->group(function () {
        Route::get('enums/{enum}', [EnumController::class, 'index']);
    Route::post('reload', function () {
        Artisan::call('migrate:refresh --seed');
    });
});
Route::post('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('view:clear');

});
