<?php

namespace App\Modules\ArticleComments\Services;

use App\Modules\ArticleComments\Contracts\ArticleCommentsServiceInterface;
use App\Modules\ArticleComments\Models\ArticleComments;
use Illuminate\Database\Eloquent\Collection;

class ArticleCommentsService implements ArticleCommentsServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return ArticleComments::with($this->resource)->get();
    }

    public function getById(int $id): ?ArticleComments
    {
        return ArticleComments::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): ArticleComments
    {
        return ArticleComments::create($data);
    }

    public function update(array $data, int $id): ArticleComments
    {
        $record = ArticleComments::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = ArticleComments::findOrFail($id);
        return $record->delete();
    }
}
