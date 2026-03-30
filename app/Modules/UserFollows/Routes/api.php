<?php

use Illuminate\Support\Facades\Route;
use App\Modules\UserFollows\Controllers\Api\UserFollowsController;

Route::apiResource('user_follows', UserFollowsController::class)->middleware(['jwt.cookies']);
