<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TopicSubscription\Controllers\Api\TopicSubscriptionController;

Route::apiResource('topic_subscriptions', TopicSubscriptionController::class)->middleware(['jwt.cookies']);
