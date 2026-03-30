<?php

namespace App\Modules\Client\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Client\Models\Client;

interface ClientServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Client;
    public function store(array $data): Client;
    public function update(array $data, int $id): Client;
    public function delete(string $pan): bool;
}
