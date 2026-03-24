<?php

namespace App\Modules\TicketType\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;

class TicketTypeResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
