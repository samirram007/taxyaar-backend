<?php
namespace App\Modules\TopicSection\Models;

use App\Modules\TopicArticle\Models\TopicArticle;
use App\Modules\TopicCategory\Models\TopicCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TopicSection extends Model
{
    use HasFactory;
    protected $connection;

    protected $table = 'topic_sections';
    public function __construct()
    {
        $this->connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
    }

    protected $fillable = [
        'name',
        'topic_category_id',
        'slug',
        'description',
        'status',
        'is_marked'

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_marked' => 'boolean',

    ];

    public function topic_category(): BelongsTo
    {
        return $this->belongsTo(TopicCategory::class, 'topic_category_id', 'id');
    }
    public function topic_articles(): HasMany
    {
        return $this->hasMany(TopicArticle::class, );
    }
}
