<?php

namespace App\Modules\TicketMessage\Services;

use App\Modules\TicketMessage\Contracts\TicketMessageServiceInterface;
use App\Modules\TicketMessage\Models\TicketMessage;
use Illuminate\Database\Eloquent\Collection;

class TicketMessageService implements TicketMessageServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TicketMessage::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketMessage
    {
        return TicketMessage::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketMessage
    {
        return TicketMessage::create($data);
    }

    public function update(array $data, int $id): TicketMessage
    {
        $record = TicketMessage::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketMessage::findOrFail($id);
        return $record->delete();
    }
}
