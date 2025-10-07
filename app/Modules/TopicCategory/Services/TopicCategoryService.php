<?php

namespace App\Modules\TopicCategory\Services;

use App\Modules\TopicCategory\Contracts\TopicCategoryServiceInterface;
use App\Modules\TopicCategory\Models\TopicCategory;
use Illuminate\Database\Eloquent\Collection;

class TopicCategoryService implements TopicCategoryServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TopicCategory::with($this->resource)->get();
    }

    public function getById(int $id): ?TopicCategory
    {
        return TopicCategory::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TopicCategory
    {
        return TopicCategory::create($data);
    }

    public function update(array $data, int $id): TopicCategory
    {
        $record = TopicCategory::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TopicCategory::findOrFail($id);
        return $record->delete();
    }
}
