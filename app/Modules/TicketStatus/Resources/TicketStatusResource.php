<?php

namespace App\Modules\TicketStatus\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;

class TicketStatusResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'isActive' => $this->is_active,
            'isPublic' => $this->is_public,
            'displayOrder' => $this->display_order,
            'colorCode' => $this->color_code
        ];
    }
}
