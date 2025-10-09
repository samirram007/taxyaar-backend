<?php
namespace App\Modules\TopicArticle\Models;

use App\Modules\TopicCategory\Models\TopicCategory;
use App\Modules\TopicSection\Models\TopicSection;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicArticle extends Model
{
    use HasFactory;
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
}
