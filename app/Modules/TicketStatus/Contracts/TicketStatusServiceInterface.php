<?php

namespace App\Modules\TicketStatus\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TicketStatus\Models\TicketStatus;

interface TicketStatusServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TicketStatus;
    public function store(array $data): TicketStatus;
    public function update(array $data, int $id): TicketStatus;
    public function delete(int $id): bool;
}
