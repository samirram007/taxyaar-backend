<?php

namespace App\Modules\Client\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;

class ClientResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'dob' => $this->dob,
            'isVerified' => $this->is_verified,
            'pan' => $this->pan,
            'validUpto' => $this->valid_upto,
            'mobileNumber' => $this->mobile_number,
            'email' => $this->email,
            'gender' => $this->gender,
            'fatherName' => $this->father_name
        ];
    }
}
