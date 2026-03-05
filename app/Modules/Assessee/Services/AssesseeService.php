<?php

namespace App\Modules\Assessee\Services;

use App\Modules\Assessee\Contracts\AssesseeServiceInterface;
use App\Modules\Assessee\Models\Assessee;
use Illuminate\Database\Eloquent\Collection;

class AssesseeService implements AssesseeServiceInterface
{
    protected $resource=[];

    public function getAll(): Collection
    {
        return Assessee::with($this->resource)->get();
    }

    public function getById(int $id): ?Assessee
    {
        return Assessee::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): Assessee
    {
        return Assessee::create($data);
    }

    public function update(array $data, int $id): Assessee
    {
        $record = Assessee::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = Assessee::findOrFail($id);
        return $record->delete();
    }
}
