<?php

use App\Modules\HelpCenter\Controllers\Api\HelpCenterController;
use Illuminate\Support\Facades\Route;

Route::apiResource('help_centers', HelpCenterController::class);
// ->middleware(['jwt.cookies']);
