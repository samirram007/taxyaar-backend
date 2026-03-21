<?php

namespace App\Modules\Client\Requests;

use App\Enums\PrimaryMobileBelongEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'first_name' => ['string', 'nullable', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'residential_status_cd' => ['nullable', 'string'],
            'isd_cd' => ['nullable', 'string', 'max:3'],
            'is_verified' => ['nullable', 'boolean'],
            'valid_upto' => ['nullable', 'date'],
            'pan' => ['required', 'string', 'unique:clients,pan'],
            'pin_cd' => ['nullable', 'string'],
            'zip_cd' => ['nullable', 'string'],
            'country_cd' => ['nullable', 'string'],
            'state_cd' => ['nullable', 'string'],
            'dob' => ['required', 'date'],
            'mobile_number' => ['required', 'string', 'max:13'],
            'gender' => ['required', 'string'],
            'email' => ['email', 'required', 'string'],
            'country' => ['somtimes', 'nullable', 'string'],
            'address_line_1' => ['sometimes', 'nullable', 'string', 'max:60'],
            'address_line_2' => ['sometimes', 'nullable', 'string', 'max:60'],
            'address_line_3' => ['sometimes', 'nullable', 'string', 'max:60'],
            'address_line_4' => ['sometimes', 'nullable', 'string', 'max:60'],
            'address_line_5' => ['sometimes', 'nullable', 'string', 'max:60'],
        ];

        // For update requests, make validation more flexible
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $id = $this->route('client');
            $rules['name'] = ['sometimes', 'required', 'string', 'max:255', 'unique:clients,name,' . $id,];
            $rules['code'] = ['sometimes', 'required', 'string', 'max:255', 'unique:clients,code,' . $id,];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.unique' => 'The name has already been taken.',
            'code.required' => 'The code field is required.',
            'code.string' => 'The code must be a string.',
            'code.max' => 'The code may not be greater than 255 characters.',
            'code.unique' => 'The code has already been taken.',
            'description.required   ' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 255 characters.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
        ];
    }
}
