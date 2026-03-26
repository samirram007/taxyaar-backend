<?php

namespace App\Modules\Document\Services;

use App\Modules\Document\Contracts\DocumentServiceInterface;
use App\Modules\Document\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\DocumentTypeEnum;

class DocumentService implements DocumentServiceInterface
{
    protected $resource = [];

    public function getAll(): Collection
    {
        return Document::with($this->resource)->get();
    }

    public function getById(int $id): ?Document
    {
        return Document::with($this->resource)->findOrFail($id);
    }

    public function store(array $data): Document
    {
        $file = $data['file'];
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $path = $file->storeAs('uploads', $fileName, 'public');
        $size = $file->getSize();
        return Document::create([
            'file_path' => $path,
            'file_type' => DocumentTypeEnum::tryFrom($extension),
            'file_size' => $size,
            'documentable_id' => $data['documentable_id'],
            'documentable_type' => $data['documentable_type'],
        ]);
    }

    public function update(array $data, int $id): Document
    {
        $record = Document::findOrFail($id);
        $record->update($data);
        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = Document::findOrFail($id);
        return $record->delete();
    }
}
