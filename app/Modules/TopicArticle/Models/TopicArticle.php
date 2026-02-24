<?php
namespace App\Modules\TopicArticle\Models;

use App\Modules\RelatedArticle\Models\RelatedArticle;
use App\Modules\TopicCategory\Models\TopicCategory;
use App\Modules\TopicSection\Models\TopicSection;
use App\Modules\User\Models\User;
use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TopicArticle extends Model
{
    use HasFactory;
    use Blameable;
    protected $connection;
    protected $table = 'topic_articles';

    protected $fillable = [
        'status',
        'topic_section_id',
        'author_id',
        'published_at',
        'title',
        'slug',
        'content',
        'is_marked',


    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'published_at' => 'datetime',
        'is_marked' => 'boolean',

    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
    }
    public function topic_section()
    {
        return $this->belongsTo(TopicSection::class, 'topic_section_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
    public function topic_category()
    {
        return $this->hasOneThrough(
            TopicCategory::class,
            TopicSection::class,
            'id',                       // Foreign key on TopicSection table
            'id',                       // Foreign key on TopicCategory table
            'topic_article_section_id', // Local key on TopicArticle table
            'topic_category_id'         // Local key on TopicSection table
        );
    }
    public function related_articles(): HasMany
    {
        return $this->hasMany(RelatedArticle::class, 'topic_article_id', 'id');
    }
    public function relatedArticles(): HasManyThrough
    {
        return $this->hasManyThrough(
            TopicArticle::class,              // Final model to return
            RelatedArticle::class,      // Intermediate pivot
            'topic_article_id',               // Foreign key on relation table
            'id',                             // Foreign key on articles table
            'id',                             // Local key on current model
            'related_topic_article_id'        // Local key on relation table
        );
    }
    // public function creator(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'created_by', 'id');
    // }
    // public function updater(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'updated_by', 'id');
    // }

}
