<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicSection\Controllers\Api\TopicSectionController;

Route::apiResource('topic_sections', TopicSectionController::class)->middleware(['jwt.cookies']);
