<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicSection\Controllers\Api\TopicSectionController;

Route::apiResource('topic_sections', TopicSectionController::class)->middleware(['jwt.cookies']);
Route::apiResource('/help_center/topic_sections', TopicSectionController::class);
Route::get('/help_center/topic_sections/{slug}/slug', [TopicSectionController::class, 'getBySlug']);
