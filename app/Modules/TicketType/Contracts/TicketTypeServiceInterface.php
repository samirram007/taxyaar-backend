<?php

namespace App\Modules\TicketType\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TicketType\Models\TicketType;

interface TicketTypeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TicketType;
    public function store(array $data): TicketType;
    public function update(array $data, int $id): TicketType;
    public function delete(int $id): bool;
}
