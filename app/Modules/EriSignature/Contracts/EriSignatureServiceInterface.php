<?php

namespace App\Modules\EriSignature\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\EriSignature\Models\EriSignature;

interface EriSignatureServiceInterface
{


    public function generateSign(string $data, string $eriId): string;
    public function verifySignedData(string $signedData, string $dataToSign, string $userId): bool;
    public function getPrivateKey(): string;
    public function getPublicCert(): string;

    public function signPayload(): array;
    public function verifyPayload(array $payload): bool;
    public function encryptPassword(string $keyB64): string;
    // public function decryptPassword(string $b64WithIv, string $base64Key): string;
}
