<?php

namespace App\Modules\Client\Services;

use App\Modules\Client\Contracts\ClientServiceInterface;
use App\Modules\Client\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientService implements ClientServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return Client::with($this->resource)->get();
    }

    public function getById(int $id): ?Client
    {
        return Client::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): Client
    {
        return Client::create($data);
    }

    public function update(array $data, int $id): Client
    {
        $record = Client::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = Client::findOrFail($id);
        return $record->delete();
    }
}
