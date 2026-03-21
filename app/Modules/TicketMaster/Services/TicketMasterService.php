<?php

namespace App\Modules\TicketMaster\Services;

use App\Modules\TicketMaster\Contracts\TicketMasterServiceInterface;
use App\Modules\TicketMaster\Models\TicketMaster;
use Illuminate\Database\Eloquent\Collection;

class TicketMasterService implements TicketMasterServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return TicketMaster::with($this->resource)->get();
    }

    public function getById(int $id): ?TicketMaster
    {
        return TicketMaster::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): TicketMaster
    {
        return TicketMaster::create($data);
    }

    public function update(array $data, int $id): TicketMaster
    {
        $record = TicketMaster::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = TicketMaster::findOrFail($id);
        return $record->delete();
    }
}
