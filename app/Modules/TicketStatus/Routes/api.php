<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TicketStatus\Controllers\Api\TicketStatusController;

Route::apiResource('ticket_statuses', TicketStatusController::class)->middleware(['jwt.cookies']);
