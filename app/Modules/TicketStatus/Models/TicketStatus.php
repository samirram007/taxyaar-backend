<?php

namespace App\Modules\TicketStatus\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class TicketStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ticket_statuses';

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'is_public',
        'display_order',
        'color_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'display_order' => 'integer'
    ];


    /**
     * @param Builder $query
     * @param String $role
     * @return Builder
     */

    public function scopeVisibleTo(Builder $query, string $role): Builder
    {
        if ($role == "customer" || $role == "user") {
            return $query->where('is_public', true);
        }
        return $query;
    }
}
