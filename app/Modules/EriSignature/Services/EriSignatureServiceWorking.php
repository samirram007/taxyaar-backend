<?php

namespace App\Modules\EriSignature\Services;

use App\Modules\EriSignature\Contracts\EriSignatureServiceInterface;
use Illuminate\Support\Facades\Log;
class EriSignatureServiceWorking implements EriSignatureServiceInterface
{
    protected $signerCert;
    protected $privateKey;
    protected $extraCerts;
    protected string $privateKeyPath;
    protected string $publicCertPath;

    protected string $publicCert;
    // public function __construct()
    // {
    //     $p12Path = config('eri.pkcs12_path');
    //     // $password = config('eri.pkcs12_password');
    //     $password = mb_convert_encoding(config('eri.pkcs12_password'), "UTF-8");
    //     if (!file_exists($p12Path)) {
    //         throw new \RuntimeException("PKCS#12 not found: $p12Path");
    //     }

    //     $p12 = file_get_contents($p12Path);
    //     $certs = [];
    //     dd(function_exists('openssl_legacy_provider_load'));
    //     if (function_exists('openssl_legacy_provider_load')) {
    //         dd('load legacy');
    //         openssl_legacy_provider_load();
    //     }
    //     if (!openssl_pkcs12_read($p12, $certs, $password)) {
    //         throw new \RuntimeException('PKCS#12 read failed: ' . openssl_error_string());
    //     }

    //     $this->signerCert = $certs['cert'];
    //     $this->privateKey = $certs['pkey'];
    //     $this->extraCerts = $certs['extracerts'] ?? [];
    // }
    public function __construct()
    {
        $this->privateKeyPath = storage_path('app/eri/private.key');
        $this->publicCertPath = storage_path('app/eri/public.pem');

        if (!file_exists($this->privateKeyPath) || !file_exists($this->publicCertPath)) {
            throw new \RuntimeException('Private key or public certificate not found.');
        }

        $this->privateKey = file_get_contents($this->privateKeyPath);
        $this->publicCert = file_get_contents($this->publicCertPath);

        if (!$this->privateKey || !$this->publicCert) {
            throw new \RuntimeException('Failed to read key or certificate files.');
        }
    }

    public function sign(string $data): string
    {
        $payload = [
            'serviceName' => config('eri.service_name'),
            'entity' => config('eri.user_id'),
            'pass' => config('eri.password'),
        ];
        $signature = '';
        $ok = openssl_sign(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $signature, $this->privateKey, OPENSSL_ALGO_SHA256);

        if (!$ok) {
            throw new \RuntimeException('Failed to sign data: ' . openssl_error_string());
        }

        return base64_encode($signature);
    }

    /**
     * Verify a signature with the public certificate
     */
    public function verify(string $data, string $signature): bool
    {
        $payload = [
            'serviceName' => config('eri.service_name'),
            'entity' => config('eri.user_id'),
            'pass' => config('eri.password'),
        ];
        $decodedSig = base64_decode($signature);
        $ok = openssl_verify(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $decodedSig, $this->publicCert, OPENSSL_ALGO_SHA256);
        return $ok === 1;
    }

    /**
     * Get raw private key content
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * Get raw public certificate content
     */
    public function getPublicCert(): string
    {
        return $this->publicCert;
    }

    public function signPayload(): array
    {
        $payload = [
            'serviceName' => config('eri.service_name'),
            'entity' => config('eri.user_id'),
            'pass' => config('eri.password'),
        ];

        $plainJson = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Temp files
        $dataFile = tempnam(sys_get_temp_dir(), 'eri_');
        $signedFile = tempnam(sys_get_temp_dir(), 'signed_');
        $chainFile = null;

        try {
            file_put_contents($dataFile, $plainJson);

            if (!empty($this->extraCerts)) {
                $chainFile = tempnam(sys_get_temp_dir(), 'chain_');
                file_put_contents($chainFile, implode("\n", $this->extraCerts));
            }

            $success = openssl_pkcs7_sign(
                $dataFile,
                $signedFile,
                $this->signerCert,
                $this->privateKey,
                [],
                PKCS7_BINARY | PKCS7_TEXT,
                OPENSSL_ALGO_SHA256,

            );

            if (!$success) {
                throw new \RuntimeException('Signing failed: ' . openssl_error_string());
            }

            $der = $this->extractDer(file_get_contents($signedFile));

            return [
                'sign' => base64_encode($der),
                'data' => base64_encode($plainJson),
                'eriUserId' => config('eri.user_id'),
            ];
        } finally {
            @unlink($dataFile);
            @unlink($signedFile);
            @unlink($chainFile ?? '');
        }
    }

    private function extractDer(string $pem): string
    {
        $pem = preg_replace('/-----BEGIN PKCS7-----|-----END PKCS7-----|\s+/', '', $pem);
        return base64_decode(trim($pem));
    }

    public function verifyPayload(array $payload): bool
    {
        $signedFile = tempnam(sys_get_temp_dir(), 'verify_');
        $contentFile = tempnam(sys_get_temp_dir(), 'content_');

        try {
            $pem = $this->wrapPem(base64_decode($payload['sign']), 'PKCS7');
            file_put_contents($signedFile, $pem);

            $success = openssl_pkcs7_verify(
                $signedFile,
                PKCS7_BINARY | PKCS7_NOINTERN,
                null,
                [],
                $contentFile
            );

            $extracted = file_get_contents($contentFile);
            return $success && ($extracted === base64_decode($payload['data']));
        } finally {
            @unlink($signedFile);
            @unlink($contentFile);
        }
    }

    private function wrapPem(string $der, string $type): string
    {
        $b64 = chunk_split(base64_encode($der), 64, "\n");
        return "-----BEGIN $type-----\n$b64-----END $type-----\n";
    }

    // AES Encryption (after ERI approval)
    public function encryptPassword(string $keyB64): string
    {
        $key = base64_decode($keyB64);
        $iv = openssl_random_pseudo_bytes(16);
        $enc = openssl_encrypt(config('eri.password'), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $enc);
    }
}
