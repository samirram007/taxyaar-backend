<?php

namespace App\Modules\SLAPolicyAction\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\SLAPolicyAction\Models\SLAPolicyAction;

interface SLAPolicyActionServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?SLAPolicyAction;
    public function store(array $data): SLAPolicyAction;
    public function update(array $data, int $id): SLAPolicyAction;
    public function delete(int $id): bool;
}
