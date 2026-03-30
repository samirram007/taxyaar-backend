<?php

namespace App\Modules\TopicComment\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TopicComment\Models\TopicComment;

interface TopicCommentServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TopicComment;
    public function store(array $data): TopicComment;
    public function update(array $data, int $id): TopicComment;
    public function delete(int $id): bool;
}
