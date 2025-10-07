<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicArticle\Controllers\Api\TopicArticleController;

Route::apiResource('topic_articles', TopicArticleController::class)->middleware(['jwt.cookies']);
