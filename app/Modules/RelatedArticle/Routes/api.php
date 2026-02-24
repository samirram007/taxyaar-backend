<?php

use Illuminate\Support\Facades\Route;
use App\Modules\RelatedArticle\Controllers\Api\RelatedArticleController;

Route::apiResource('related_articles', RelatedArticleController::class)->middleware(['jwt.cookies']);
