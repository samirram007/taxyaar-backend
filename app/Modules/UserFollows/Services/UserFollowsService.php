<?php

namespace App\Modules\UserFollows\Services;

use App\Modules\UserFollows\Contracts\UserFollowsServiceInterface;
use App\Modules\UserFollows\Models\UserFollows;
use Illuminate\Database\Eloquent\Collection;

class UserFollowsService implements UserFollowsServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return UserFollows::with($this->resource)->get();
    }

    public function getById(int $id): ?UserFollows
    {
        return UserFollows::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): UserFollows
    {
        return UserFollows::create($data);
    }

    public function update(array $data, int $id): UserFollows
    {
        $record = UserFollows::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = UserFollows::findOrFail($id);
        return $record->delete();
    }
}
