<?php

namespace App\Modules\TopicSection\Services;

use App\Modules\TopicSection\Contracts\TopicSectionServiceInterface;
use App\Modules\TopicSection\Models\TopicSection;
use Illuminate\Database\Eloquent\Collection;

class TopicSectionService implements TopicSectionServiceInterface
{
    protected $resource = ['topic_category', 'topic_articles'];

    public function getAll(): Collection
    {
        return TopicSection::with($this->resource)->get();
    }

    public function getById(int $id): ?TopicSection
    {
        return TopicSection::with($this->resource)->findOrFail($id);
    }

    public function getBySlug(string $slug): ?TopicSection
    {
        $localResource = ['topic_category', 'topic_articles'];
        return TopicSection::with($localResource)->where('slug', $slug)->firstOrFail();
    }

    public function store(array $data): TopicSection
    {
        return TopicSection::create($data);
    }

    public function update(array $data, int $id): TopicSection
    {
        $record = TopicSection::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TopicSection::findOrFail($id);
        return $record->delete();
    }
}
