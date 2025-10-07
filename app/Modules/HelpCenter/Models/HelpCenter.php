<?php
namespace App\Modules\HelpCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpCenter extends Model
{
    use HasFactory;
    protected $connection;
    protected $table = 'help_centers';

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = env('HELP_CENTER_DB_CONNECTION', '');
    }
}
