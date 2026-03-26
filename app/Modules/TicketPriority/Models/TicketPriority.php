<?php

namespace App\Modules\TicketPriority\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketPriority extends Model
{
    use HasFactory;

    protected $table = 'ticket_priorities';

    protected $fillable = [
        'name',
        'code',
        'description',
        'sla',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
