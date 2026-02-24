<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicCategory\Controllers\Api\TopicCategoryController;

Route::apiResource('topic_categories', TopicCategoryController::class)->middleware(['jwt.cookies']);
Route::apiResource('/help_center/topic_categories', TopicCategoryController::class);
Route::get('/help_center/topic_categories/{slug}/slug', [TopicCategoryController::class, 'getBySlug']);

