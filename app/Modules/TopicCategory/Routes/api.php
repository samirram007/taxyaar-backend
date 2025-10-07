<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicCategory\Controllers\Api\TopicCategoryController;

Route::apiResource('topic_categories', TopicCategoryController::class)->middleware(['jwt.cookies']);
