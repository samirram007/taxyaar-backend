<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicArticle\Controllers\Api\TopicArticleController;

Route::apiResource('topic_articles', TopicArticleController::class)->middleware(['jwt.cookies']);
Route::get('/help_center_topic_articles/{slug}/slug', [TopicArticleController::class, 'getBySlug'])->name('topic_articles.slug');
Route::apiResource('/help_center_topic_articles', TopicArticleController::class);
