<?php

namespace App\Modules\Document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\DocumentTypeEnum;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'file_path',
        'file_type',
        'file_size',
        'documentable_id',
        'documentable_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'file_type' => DocumentTypeEnum::class
    ];


    public function documentable()
    {
        return $this->morphTo();
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
