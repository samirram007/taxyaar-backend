<?php

namespace App\Modules\SLAPolicyAction\Services;

use App\Modules\SLAPolicyAction\Contracts\SLAPolicyActionServiceInterface;
use App\Modules\SLAPolicyAction\Models\SLAPolicyAction;
use Illuminate\Database\Eloquent\Collection;

class SLAPolicyActionService implements SLAPolicyActionServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return SLAPolicyAction::with($this->resource)->get();
    }

    public function getById(int $id): ?SLAPolicyAction
    {
        return SLAPolicyAction::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): SLAPolicyAction
    {
        return SLAPolicyAction::create($data);
    }

    public function update(array $data, int $id): SLAPolicyAction
    {
        $record = SLAPolicyAction::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = SLAPolicyAction::findOrFail($id);
        return $record->delete();
    }
}
