<?php

namespace App\Modules\TicketMaster\Services;

use App\Modules\TicketMaster\Contracts\TicketMasterServiceInterface;
use App\Modules\TicketMaster\Models\TicketMaster;
use Illuminate\Database\Eloquent\Collection;

class TicketMasterService implements TicketMasterServiceInterface
{
    protected $resource = [];

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
        $data['ticket_id'] = 1;
        return TicketMaster::create($data);
    }


    private function generateTicketId(string $pan, string $mobileNumber): string
    {
        $epoch = now()->timestamp;
        $rand = mt_rand(100, 999);

        return strtoupper(substr($pan, 0, 5)) .
            substr($mobileNumber, -4) .
            $epoch .
            $rand;
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
