<?php

use Illuminate\Support\Facades\Route;
use App\Modules\EriSignature\Controllers\Api\EriSignatureController;

//Route::apiResource('eri_signatures', EriSignatureController::class);
Route::post('eri-login/login', [EriSignatureController::class, 'login']);
