<?php

namespace App\Modules\Assessee\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Assessee\Models\Assessee;

interface AssesseeServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Assessee;
    public function store(array $data): Assessee;
    public function update(array $data, int $id): Assessee;
    public function delete(int $id): bool;
}
