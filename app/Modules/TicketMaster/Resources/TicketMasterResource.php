<?php

namespace App\Modules\TicketMaster\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;

class TicketMasterResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'ticketId' => $this->ticket_id,
            'typeId' => $this->type_id,
            'statusId' => $this->status_id,
            'pan' => $this->pan,
            'platform' => $this->platform,
            'subject' => $this->subject,
            'description' => $this->description,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}