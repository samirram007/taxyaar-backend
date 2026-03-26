<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TicketEvent\Controllers\Api\TicketEventController;

Route::apiResource('ticket_events', TicketEventController::class)->middleware(['jwt.cookies']);
