<?php

namespace App\Modules\TicketEvent\Services;

use App\Modules\TicketEvent\Contracts\TicketEventServiceInterface;
use App\Modules\TicketEvent\Models\TicketEvent;
use Illuminate\Database\Eloquent\Collection;

class TicketEventService implements TicketEventServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TicketEvent::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketEvent
    {
        return TicketEvent::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketEvent
    {
        return TicketEvent::create($data);
    }

    public function update(array $data, int $id): TicketEvent
    {
        $record = TicketEvent::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketEvent::findOrFail($id);
        return $record->delete();
    }
}
