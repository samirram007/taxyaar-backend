<?php

namespace App\Modules\TicketPriority\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TicketPriority\Models\TicketPriority;

interface TicketPriorityServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TicketPriority;
    public function store(array $data): TicketPriority;
    public function update(array $data, int $id): TicketPriority;
    public function delete(int $id): bool;
}
