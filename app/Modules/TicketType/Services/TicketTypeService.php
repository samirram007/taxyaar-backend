<?php

namespace App\Modules\TicketType\Services;

use App\Modules\TicketType\Contracts\TicketTypeServiceInterface;
use App\Modules\TicketType\Models\TicketType;
use Illuminate\Database\Eloquent\Collection;

class TicketTypeService implements TicketTypeServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TicketType::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketType
    {
        return TicketType::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketType
    {
        return TicketType::create($data);
    }

    public function update(array $data, int $id): TicketType
    {
        $record = TicketType::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketType::findOrFail($id);
        return $record->delete();
    }
}
