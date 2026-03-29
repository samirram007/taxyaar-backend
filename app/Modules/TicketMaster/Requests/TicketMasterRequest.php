<?php

namespace App\Modules\TicketMaster\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\TicketStatus;
use App\Enums\DevicePlatform;

class TicketMasterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'mobile_number' => ['required', 'string', 'max:20'],
            'ticket_type_id' => ['required', 'numeric'],
            'priority_id' => ['nullable', 'numeric'],
            'status_id' => ['nullable', 'numeric'],
            'assigned_by' => ['sometimes', 'required', 'string'],
            'assigned_by_id' => ['nullable', 'numeric'],
            'assigned_to' => ['nullable', 'numeric'],
            'email' => ['required', 'email', 'string', 'max:255'],
            'paused_at' => ['nullable', 'date'],
            'paused_duration' => ['nullable', 'string'],
            'pan' => ['required', 'string', 'max:10'],
            'platform' => ['sometimes', 'required', new Enum(DevicePlatform::class)],
            'subject' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'file' => ['nullable', 'file', 'mimetypes:application/pdf,image/jpeg,image/png,text/plain'],
        ];

        // For update requests, make validation more flexible
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $id = $this->route('ticket_master');
            $rules['name'] = ['sometimes', 'required', 'string', 'max:255', 'unique:ticket_masters,name,' . $id,];
            $rules['code'] = ['sometimes', 'required', 'string', 'max:255', 'unique:ticket_masters,code,' . $id,];
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