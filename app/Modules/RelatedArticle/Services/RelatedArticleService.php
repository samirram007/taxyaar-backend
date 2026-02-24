<?php

namespace App\Modules\RelatedArticle\Services;

use App\Modules\RelatedArticle\Contracts\RelatedArticleServiceInterface;
use App\Modules\RelatedArticle\Models\RelatedArticle;
use Illuminate\Database\Eloquent\Collection;

class RelatedArticleService implements RelatedArticleServiceInterface
{
    protected $resource = ['related_topic_article'];

    public function getAll(): Collection
    {
        return RelatedArticle::with($this->resource)->get();
    }

    public function getById(int $id): ?RelatedArticle
    {
        return RelatedArticle::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): RelatedArticle
    {
        return RelatedArticle::create($data);
    }

    public function update(array $data, int $id): RelatedArticle
    {
        $record = RelatedArticle::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = RelatedArticle::findOrFail($id);
        return $record->delete();
    }
}
