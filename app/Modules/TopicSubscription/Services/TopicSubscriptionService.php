<?php

namespace App\Modules\TopicSubscription\Services;

use App\Modules\TopicSubscription\Contracts\TopicSubscriptionServiceInterface;
use App\Modules\TopicSubscription\Models\TopicSubscription;
use Illuminate\Database\Eloquent\Collection;

class TopicSubscriptionService implements TopicSubscriptionServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TopicSubscription::with($this->resource)->get();
    }

    public function getById(int $id): ?TopicSubscription
    {
        return TopicSubscription::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TopicSubscription
    {
        return TopicSubscription::create($data);
    }

    public function update(array $data, int $id): TopicSubscription
    {
        $record = TopicSubscription::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TopicSubscription::findOrFail($id);
        return $record->delete();
    }
}
