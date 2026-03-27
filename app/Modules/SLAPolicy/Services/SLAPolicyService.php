<?php

namespace App\Modules\SLAPolicy\Services;

use App\Modules\SLAPolicy\Contracts\SLAPolicyServiceInterface;
use App\Modules\SLAPolicy\Models\SLAPolicy;
use Illuminate\Database\Eloquent\Collection;

class SLAPolicyService implements SLAPolicyServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return SLAPolicy::with($this->resource)->get();
    }

    public function getById(int $id): ?SLAPolicy
    {
        return SLAPolicy::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): SLAPolicy
    {
        return SLAPolicy::create($data);
    }

    public function update(array $data, int $id): SLAPolicy
    {
        $record = SLAPolicy::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = SLAPolicy::findOrFail($id);
        return $record->delete();
    }
}
