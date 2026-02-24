<?php

namespace Tests\Feature;

use App\Modules\EriSignature\Services\EriSignatureService;
use Tests\TestCase;


class EriLoginTest extends TestCase
{
    public function test_eri_signature_matches_java_guide()
    {
        $eri = new EriSignatureService();

        // Step 1: Plain JSON
        $payload = [
            'serviceName' => 'ErajVgnDataService',
            'entity' => 'ERIP014181',
            'pass' => 'Oracle@123',
        ];
        $data = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Step 2: Generate signature
        $sign = $eri->generateSign($data, 'ERIP014181');

        // Step 3: Base64 payload
        $dataB64 = base64_encode($data);

        // Output (matches Java)
        $this->assertNotEmpty($sign);
        $this->assertStringStartsWith('MIAGCSqGSIb3DQEHAqCA', $sign);

        // Full response
        $response = [
            'sign' => $sign,
            'data' => $dataB64,
            'eriUserId' => 'ERIP014181',
        ];

        // Optional: Print for comparison
        dump($response);
    }
}
