<?php

namespace App\Enums;

enum DocumentTypeEnum: string
{
    case JPG = 'jpg';
    case JPEG = 'jpeg';
    case PNG = 'png';
    case WEBP = 'webp';
    case XLS = 'xls';
    case XLSX = 'xlsx';
    case CSV = 'csv';
    case DOC = 'doc';
    case DOCX = 'docx';
    case TXT = 'txt';
    case PDF = 'pdf';

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}