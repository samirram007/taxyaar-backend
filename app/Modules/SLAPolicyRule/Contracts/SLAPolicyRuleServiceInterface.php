<?php

namespace App\Modules\SLAPolicyRule\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\SLAPolicyRule\Models\SLAPolicyRule;

interface SLAPolicyRuleServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?SLAPolicyRule;
    public function store(array $data): SLAPolicyRule;
    public function update(array $data, int $id): SLAPolicyRule;
    public function delete(int $id): bool;
}
