<?php

namespace App\Modules\ArticleComments\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\ArticleComments\Models\ArticleComments;

interface ArticleCommentsServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?ArticleComments;
    public function store(array $data): ArticleComments;
    public function update(array $data, int $id): ArticleComments;
    public function delete(int $id): bool;
}
