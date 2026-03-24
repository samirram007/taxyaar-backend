<?php

namespace App\Modules\TicketMessage\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\TicketMessage\Models\TicketMessage;

interface TicketMessageServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?TicketMessage;
    public function store(array $data): TicketMessage;
    public function update(array $data, int $id): TicketMessage;
    public function delete(int $id): bool;
}
