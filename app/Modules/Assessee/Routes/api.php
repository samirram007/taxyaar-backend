<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Assessee\Controllers\Api\AssesseeController;

Route::apiResource('assessees', AssesseeController::class)->middleware(['jwt.cookies']);
