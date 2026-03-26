<?php

namespace App\Modules\TicketEventType\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TicketEventType\Models\TicketEventType;

interface TicketEventTypeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TicketEventType;
    public function store(array $data): TicketEventType;
    public function update(array $data, int $id): TicketEventType;
    public function delete(int $id): bool;
}
