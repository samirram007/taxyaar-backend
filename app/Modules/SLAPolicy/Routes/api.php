<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SLAPolicy\Controllers\Api\SLAPolicyController;

Route::apiResource('s_l_a_policies', SLAPolicyController::class)->middleware(['jwt.cookies']);
