<?php

namespace App\Modules\EriSignature\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\EriSignature\Contracts\EriSignatureServiceInterface;
use App\Modules\EriSignature\Resources\EriSignatureResource;
use App\Modules\EriSignature\Resources\EriSignatureCollection;
use App\Modules\EriSignature\Requests\EriSignatureRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Modules\EriSignature\Services\EriSignatureService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class EriSignatureController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected EriSignatureServiceInterface $service)
    {
    }

    public function login()
    {
        //$payload = $this->service->signPayload();

        // $data = $payload;
        $eriId = 'ERIP014181';

        $data = "This is a test message for signing";
        // dd($data);
        // Sign
        $signature = $this->service->generateSign($data, $eriId);

        // Verify
        $isValid = $this->service->verifySignedData($signature, $data, $eriId);

        //dd($signature, $isValid);
        return response()->json([
            'data' => [
                'signature' => $signature,
                'is_valid' => $isValid,
            ],
        ]);

        // Self-test
        // $verified = $this->service->verifyPayload($payload);
        // \Log::info("ERI Self-Verification: " . ($verified ? 'PASS' : 'FAIL'));

        // // Send to UAT API
        // $response = Http::post('https://uat-eri-api.example.com/login', $payload);

        // return $response->json();
    }

    public function Clogin()
    {
        $eri = app($this->service());
        $payload = $eri->signPayload();

        return response()->json($payload);
    }
}
