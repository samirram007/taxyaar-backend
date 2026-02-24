<?php

namespace App\Modules\TopicArticle\Services;

use App\Modules\TopicArticle\Contracts\TopicArticleServiceInterface;
use App\Modules\TopicArticle\Models\TopicArticle;
use Illuminate\Database\Eloquent\Collection;

class TopicArticleService implements TopicArticleServiceInterface
{
    protected $resource = ['topic_section.topic_category', 'creator', 'updater'];

    public function getAll(): Collection
    {

        return TopicArticle::with($this->resource)->get();
    }

    public function getById(int $id): ?TopicArticle
    {
        return TopicArticle::with($this->resource)->findOrFail($id);
    }
    public function getBySlug(string $slug): ?TopicArticle
    {
        $localResource = ['topic_section.topic_category', 'relatedArticles', 'creator', 'updater'];
        return TopicArticle::with($localResource)->where('slug', $slug)->firstOrFail();
    }

    public function store(array $data): TopicArticle
    {
        //dd($data);
        return TopicArticle::create($data);
    }

    public function update(array $data, int $id): TopicArticle
    {
        $record = TopicArticle::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TopicArticle::findOrFail($id);
        return $record->delete();
    }
}
