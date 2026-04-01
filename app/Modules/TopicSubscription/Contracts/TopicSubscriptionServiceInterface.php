<?php

namespace App\Modules\TopicSubscription\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TopicSubscription\Models\TopicSubscription;

interface TopicSubscriptionServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TopicSubscription;
    public function store(array $data): TopicSubscription;
    public function update(array $data, int $id): TopicSubscription;
    public function delete(int $id): bool;
}
