<?php

namespace App\Modules\EriSignature\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;
class SignedDataResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'sign' => $this->sign,
            'data' => $this->data,
            'eriUserId' => $this->eri_user_id,

        ];
    }
}
