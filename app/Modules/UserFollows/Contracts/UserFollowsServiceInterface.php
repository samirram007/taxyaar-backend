<?php

namespace App\Modules\UserFollows\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\UserFollows\Models\UserFollows;

interface UserFollowsServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?UserFollows;
    public function store(array $data): UserFollows;
    public function update(array $data, int $id): UserFollows;
    public function delete(int $id): bool;
}
