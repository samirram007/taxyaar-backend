<?php

namespace App\Modules\TopicSection\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TopicSection\Models\TopicSection;

interface TopicSectionServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TopicSection;
    public function getBySlug(string $slug): ?TopicSection;
    public function store(array $data): TopicSection;
    public function update(array $data, int $id): TopicSection;
    public function delete(int $id): bool;
}
