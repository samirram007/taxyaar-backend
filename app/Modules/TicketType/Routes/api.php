<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TicketType\Controllers\Api\TicketTypeController;

Route::apiResource('ticket_types', TicketTypeController::class)->middleware(['jwt.cookies']);
