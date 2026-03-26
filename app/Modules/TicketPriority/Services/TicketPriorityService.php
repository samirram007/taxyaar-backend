<?php

namespace App\Modules\TicketPriority\Services;

use App\Modules\TicketPriority\Contracts\TicketPriorityServiceInterface;
use App\Modules\TicketPriority\Models\TicketPriority;
use Illuminate\Database\Eloquent\Collection;

class TicketPriorityService implements TicketPriorityServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TicketPriority::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketPriority
    {
        return TicketPriority::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketPriority
    {
        return TicketPriority::create($data);
    }

    public function update(array $data, int $id): TicketPriority
    {
        $record = TicketPriority::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketPriority::findOrFail($id);
        return $record->delete();
    }
}
