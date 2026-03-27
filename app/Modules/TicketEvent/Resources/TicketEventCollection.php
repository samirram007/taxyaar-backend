<?php

namespace App\Modules\TicketEvent\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessCollection;

class TicketEventCollection extends SuccessCollection
{

         /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
