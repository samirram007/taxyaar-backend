<?php

namespace App\Modules\TicketEventType\Services;

use App\Modules\TicketEventType\Contracts\TicketEventTypeServiceInterface;
use App\Modules\TicketEventType\Models\TicketEventType;
use Illuminate\Database\Eloquent\Collection;

class TicketEventTypeService implements TicketEventTypeServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TicketEventType::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketEventType
    {
        return TicketEventType::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketEventType
    {
        return TicketEventType::create($data);
    }

    public function update(array $data, int $id): TicketEventType
    {
        $record = TicketEventType::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketEventType::findOrFail($id);
        return $record->delete();
    }
}
