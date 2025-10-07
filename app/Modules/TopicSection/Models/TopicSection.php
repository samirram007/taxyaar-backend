<?php
namespace App\Modules\TopicSection\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function topic_category()
    {
        return $this->belongsTo(\App\Modules\TopicCategory\Models\TopicCategory::class, 'topic_category_id');
    }
    public function articles()
    {
        return $this->hasMany(\App\Modules\TopicArticle\Models\TopicArticle::class, 'topic_article_section_id');
    }
}
