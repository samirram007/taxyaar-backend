<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Client\Controllers\Api\ClientController;

Route::apiResource('clients', ClientController::class)->middleware(['jwt.cookies']);
