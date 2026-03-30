<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ArticleComments\Controllers\Api\ArticleCommentsController;

Route::apiResource('article_comments', ArticleCommentsController::class)->middleware(['jwt.cookies']);
