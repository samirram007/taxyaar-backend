<?php

use Illuminate\Support\Facades\Route;
use App\Modules\SLAPolicyAction\Controllers\Api\SLAPolicyActionController;

Route::apiResource('s_l_a_policy_actions', SLAPolicyActionController::class)->middleware(['jwt.cookies']);
