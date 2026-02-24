<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicArticle\Controllers\Api\TopicArticleController;

Route::apiResource('topic_articles', TopicArticleController::class)->middleware(['jwt.cookies']);
Route::apiResource('/help_center/topic_articles', TopicArticleController::class);
Route::get('/help_center/topic_articles/{slug}/slug', [TopicArticleController::class, 'getBySlug']);
