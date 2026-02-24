<?php
namespace App\Modules\TopicCategory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TopicCategory extends Model
{
    use HasFactory;
    protected $connection;

    public function __construct()
    {
        $this->connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
    }
    protected $table = 'topic_categories';

    protected $fillable = ['name', 'slug', 'description', 'status', 'icon'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function topic_sections(): HasMany
    {
        return $this->hasMany(
            \App\Modules\TopicSection\Models\TopicSection::class,
            'topic_category_id'
        );
    }
    public function topic_articles(): HasManyThrough
    {
        return $this->hasManyThrough(
            \App\Modules\TopicArticle\Models\TopicArticle::class,
            \App\Modules\TopicSection\Models\TopicSection::class,
            'topic_category_id',        // Foreign key on TopicSection table
            'topic_article_section_id', // Foreign key on TopicArticle table
            'id',                       // Local key on TopicCategory table
            'id'                        // Local key on TopicSection table
        );
    }
}
