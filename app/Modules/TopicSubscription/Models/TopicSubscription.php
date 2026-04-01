<?php

namespace App\Modules\TopicSubscription\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicSubscription extends Model
{
    use HasFactory;

    protected $table = 'topic_subscriptions';


    protected $fillable = [
        'user_id',
        'subscribable_id',
        'subscribable_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribable()
    {
        return $this->morphTo();
    }
}