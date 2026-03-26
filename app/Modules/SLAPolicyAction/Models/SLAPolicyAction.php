<?php

namespace App\Modules\SLAPolicyAction\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SLAPolicyAction extends Model
{
    use HasFactory;

    protected $table = 's_l_a_policy_actions';

    protected $fillable = [
        'name',
        'code',
        'description',
        'status',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
