<?php

namespace App\Modules\Client\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'email',
        'last_name',
        'father_name',
        'residential_status_code',
        'isd_code',
        'is_verified',
        'valid_upto',
        'pan',
        'pin_code',
        'zip_code',
        'country_code',
        'state_code',
        'dob',
        'mobile_number',
        'gender',
        'country',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
