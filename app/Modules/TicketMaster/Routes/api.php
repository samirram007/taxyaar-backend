<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TicketMaster\Controllers\Api\TicketMasterController;

Route::apiResource('ticket_masters', TicketMasterController::class)->middleware(['jwt.cookies']);
