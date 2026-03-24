<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TicketMessage\Controllers\Api\TicketMessageController;

Route::apiResource('ticket_messages', TicketMessageController::class)->middleware(['jwt.cookies']);
