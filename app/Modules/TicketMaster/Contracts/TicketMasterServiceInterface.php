<?php

namespace App\Modules\TicketMaster\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TicketMaster\Models\TicketMaster;

interface TicketMasterServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TicketMaster;
    public function store(array $data): TicketMaster;
    public function update(array $data, int $id): TicketMaster;
    public function delete(int $id): bool;
}
