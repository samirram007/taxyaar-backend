<?php

use Illuminate\Support\Facades\Route;
use App\Modules\TicketMaster\Controllers\Api\TicketMasterController;

Route::apiResource('ticket_master', TicketMasterController::class);
