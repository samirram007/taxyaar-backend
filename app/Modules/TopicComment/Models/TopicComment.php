<?php

namespace App\Modules\TopicComment\Models;

use App\Modules\User\Models\User;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicComment extends Model
{
    use HasFactory, SoftDeletes, Blameable;

    protected $connection;
    protected $table = 'topic_comments';

    protected $fillable = [
        'user_id',
        'comment',
        'remark',
        'commentable_id',
        'commentable_type',
        'status',
        'approved_by',
        'approved_at',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}