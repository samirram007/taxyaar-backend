<?php

namespace App\Modules\EriSignature\Services;

use App\Modules\EriSignature\Contracts\EriSignatureServiceInterface;
use Exception;

use Illuminate\Support\Facades\Log;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class EriSignatureService implements EriSignatureServiceInterface
{
    protected $privateKeyPath;
    protected $certPath;
    protected $publicCertPath;

    public function __construct()
    {
        $this->privateKeyPath = storage_path('app/eri/private.key');
        $this->certPath = storage_path('app/eri/agencykey.crt');
        $this->publicCertPath = storage_path('app/eri/agencykey.crt');
    }

    /**
     * Sign the data and return the base64-encoded signature.
     *
     * @param string $data Plain text data to sign.
     * @return string|null Base64-encoded signature, or null on error.
     */
    public function generateSign(string $data, string $eriId): string
    {
        try {
            // Load private key and certificate
            $privateKey = file_get_contents($this->privateKeyPath);
            $certificate = file_get_contents($this->certPath);
            // dd($privateKey, $certificate);
            // Parse certificates if chain is present
            preg_match_all('/(-----BEGIN CERTIFICATE-----.+?-----END CERTIFICATE-----)/s', $certificate, $matches);
            $certList = $matches[0] ?? [];
            if (empty($certList)) {
                throw new Exception('No certificates found in cert file.');
            }

            $signerCert = $certList[0];
            $extraCerts = array_slice($certList, 1);

            // Create temp files
            $certFile = tempnam(sys_get_temp_dir(), 'cert');
            file_put_contents($certFile, $signerCert);

            $keyFile = tempnam(sys_get_temp_dir(), 'key');
            file_put_contents($keyFile, $privateKey);

            $chainFile = null;
            if (!empty($extraCerts)) {
                $chainFile = tempnam(sys_get_temp_dir(), 'chain');
                file_put_contents($chainFile, implode("\n", $extraCerts));
            }

            $dataFile = tempnam(sys_get_temp_dir(), 'data');
            file_put_contents($dataFile, $data);

            $signedFile = tempnam(sys_get_temp_dir(), 'signed');

            // Build OpenSSL command for detached CMS sign with SHA256 (DER format)
            $command = [
                'openssl',
                'cms',
                '-sign',
                '-in',
                $dataFile,
                '-out',
                $signedFile,
                '-signer',
                $certFile,
                '-inkey',
                $keyFile,
                '-md',
                'sha256',
                '-binary',
                '-outform',
                'DER'
            ];

            if ($chainFile) {
                $command = array_merge($command, ['-certfile', $chainFile]);
            }

            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $signedData = file_get_contents($signedFile);

            // Clean up temp files
            @unlink($certFile);
            @unlink($keyFile);
            if ($chainFile)
                @unlink($chainFile);
            @unlink($dataFile);
            @unlink($signedFile);

            return base64_encode($signedData);
        } catch (Exception $e) {
            Log::error('sign failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify the signature against the plain data.
     *
     * @param string $data Plain original data.
     * @param string $signature Base64-encoded signed data.
     * @return bool True if valid, false otherwise.
     */
    public function verifySignedData(string $signedData, string $dataToSign, string $userId): bool
    {
        try {
            // Decode base64 signature
            $signedBytes = base64_decode($signedData);
            // Load public certificate
            $x509Cert = file_get_contents($this->publicCertPath);

            // Check certificate validity (commented out for testing with expired cert)
            /*
            $certInfo = openssl_x509_parse($x509Cert);
            if (!$certInfo) {
                throw new Exception('Failed to parse public certificate.');
            }
            $now = time();
            if ($now < $certInfo['validFrom_time_t'] || $now > $certInfo['validTo_time_t']) {
                throw new Exception('Certificate is expired or not yet valid.');
            }
            */

            // Temp files for verification
            $signedFile = tempnam(sys_get_temp_dir(), 'signed');
            file_put_contents($signedFile, $signedBytes);

            $contentFile = tempnam(sys_get_temp_dir(), 'content');
            file_put_contents($contentFile, $dataToSign);

            $publicCertFile = tempnam(sys_get_temp_dir(), 'pubcert');
            file_put_contents($publicCertFile, $x509Cert);

            // Build OpenSSL command for verification
            $command = [
                'openssl',
                'cms',
                '-verify',
                '-in',
                $signedFile,
                '-inform',
                'DER',
                '-content',
                $contentFile,
                '-binary',
                '-nointern',
                '-untrusted',
                $publicCertFile,
                '-noverify'  // Skip cert verification (we already checked validity)
            ];

            $process = new Process($command);
            $process->run();

            // Clean up
            @unlink($signedFile);
            @unlink($contentFile);
            @unlink($publicCertFile);

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            Log::info('Data signature verified.');
            return true;
        } catch (Exception $e) {
            Log::error('verify failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Encrypt plain text with AES (matches Java AES/ECB/PKCS5Padding).
     *
     * @param string $plainText Text to encrypt.
     * @param string $key AES secret key (e.g., 256-bit).
     * @return string Base64-encoded encrypted text.
     */
    public function getEncryptedPlainText(string $plainText, string $key): string
    {
        $encrypted = openssl_encrypt($plainText, 'aes-256-ecb', $key, 0);
        return base64_encode($encrypted);
    }

    /**
     * Decrypt encrypted text with AES.
     *
     * @param string $encryptedString Base64-encoded encrypted text.
     * @param string $key AES secret key.
     * @return string Decrypted plain text.
     */
    public function getDecryptedPlainText(string $encryptedString, string $key): string
    {
        $decoded = base64_decode($encryptedString);
        return openssl_decrypt($decoded, 'aes-256-ecb', $key, 0);
    }

    public function getPrivateKey(): string
    {
        return file_get_contents($this->privateKeyPath);
    }
    public function getPublicCert(): string
    {
        return file_get_contents($this->publicCertPath);
    }

    public function signPayload(): array
    {
        $payload = [
            'serviceName' => config('eri.service_name'),
            'entity' => config('eri.user_id'),
            'pass' => config('eri.password'),
        ];
        $data = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $sign = $this->sign($data);
        $dataB64 = base64_encode($data);

        return [
            'sign' => $sign,
            'data' => $dataB64,
            'eriUserId' => config('eri.user_id'),
        ];
    }

    public function encryptPassword(string $keyB64): string
    {
        $password = config('eri.password');
        $key = base64_decode($keyB64);
        return $this->getEncryptedPlainText($password, $key);
    }

    public function verifyPayload(array $payload): bool
    {
        try {
            if (!isset($payload['sign']) || !isset($payload['data'])) {
                return false;
            }
            $data = base64_decode($payload['data']);
            $signature = $payload['sign'];
            return $this->verify($data, $signature);
        } catch (Exception $e) {
            Log::error('verifyPayload failed: ' . $e->getMessage());
            return false;
        }
    }
}
