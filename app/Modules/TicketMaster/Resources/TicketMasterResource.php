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
            'assignedBy' => $this->assigned_by,
            'assignedById' => $this->assigned_by_id,
            'assignedTo' => $this->assigned_to,
            'typeId' => $this->type_id,
            'priorityId' => $this->priority_id,
            'statusId' => $this->status_id,
            'mobileNumber' => $this->mobile_number,
            'email' => $this->email,
            'pan' => $this->pan,
            'platform' => $this->platform,
            'subject' => $this->subject,
            'description' => $this->description,
            'pausedAt' => $this->paused_at?->toISOString(),
            'pausedDuration' => $this->paused_duration,
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
        ];
    }
}
