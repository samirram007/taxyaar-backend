<?php

namespace App\Modules\TopicComment\Services;

use App\Modules\TopicArticle\Models\TopicArticle;
use App\Modules\TopicComment\Contracts\TopicCommentServiceInterface;
use App\Modules\TopicComment\Models\TopicComment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TopicCommentService implements TopicCommentServiceInterface
{
    protected $resource = [];

    public function getAll(): Collection
    {
        return TopicComment::with($this->resource)->get();
    }

    public function getById(int $id): ?TopicComment
    {
        return TopicComment::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TopicComment
    {
        $data['user_id'] = Auth::id();
        $data['commentable_type'] = 'article';
        return TopicComment::create($data);
    }

    public function update(array $data, int $id): TopicComment
    {
        $record = TopicComment::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TopicComment::findOrFail($id);
        return $record->delete();
    }
}