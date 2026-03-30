<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicComment\Controllers\Api\TopicCommentController;

Route::apiResource('topic_comments', TopicCommentController::class)->middleware(['jwt.cookies']);
