<?php

namespace App\Modules\HelpCenter\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\HelpCenter\Models\HelpCenter;

interface HelpCenterServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?HelpCenter;
    public function store(array $data): HelpCenter;
    public function update(array $data, int $id): HelpCenter;
    public function delete(int $id): bool;
}
