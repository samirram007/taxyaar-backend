<?php

namespace App\Modules\SLAPolicyRule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SLAPolicyRule extends Model
{
    use HasFactory;

    protected $table = 's_l_a_policy_rules';

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
