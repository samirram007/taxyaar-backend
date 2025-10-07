<?php

namespace App\Modules\TopicArticle\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TopicArticle\Models\TopicArticle;

interface TopicArticleServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TopicArticle;
    public function store(array $data): TopicArticle;
    public function update(array $data, int $id): TopicArticle;
    public function delete(int $id): bool;
}
