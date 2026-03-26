<?php

namespace App\Modules\TicketMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketMaster extends Model
{
    use HasFactory;

    protected $table = 'ticket_masters';

    protected $fillable = [
        'ticket_id',
        'assigned_by',
        'assigned_by_id',
        'assigned_to',
        'type_id',
        'priority_id',
        'status_id',
        'mobile_number',
        'email',
        'pan',
        'platform',
        'subject',
        'description',
        'paused_at',
        'paused_duration',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
