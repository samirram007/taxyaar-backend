<?php

namespace App\Modules\RelatedArticle\Models;

use App\Modules\TopicArticle\Models\TopicArticle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RelatedArticle extends Model
{
    use HasFactory;
    protected $connection;
    protected $table = 'related_articles';

    public $timestamps = false;
    public function __construct()
    {
        $this->connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
    }

    protected $fillable = [
        'topic_article_id',
        'related_topic_article_id',


    ];

    protected $casts = [
    ];

    public function topic_article(): BelongsTo
    {
        return $this->belongsTo(TopicArticle::class, 'topic_article_id', 'id');
    }
    public function related_topic_article(): BelongsTo
    {
        return $this->belongsTo(TopicArticle::class, 'related_topic_article_id', 'id');
    }
}
