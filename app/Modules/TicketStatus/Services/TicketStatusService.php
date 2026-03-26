<?php

namespace App\Modules\TicketStatus\Services;

use App\Modules\TicketStatus\Contracts\TicketStatusServiceInterface;
use App\Modules\TicketStatus\Models\TicketStatus;
use Illuminate\Database\Eloquent\Collection;

class TicketStatusService implements TicketStatusServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TicketStatus::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketStatus
    {
        return TicketStatus::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketStatus
    {
        return TicketStatus::create($data);
    }

    public function update(array $data, int $id): TicketStatus
    {
        $record = TicketStatus::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketStatus::findOrFail($id);
        return $record->delete();
    }
}
