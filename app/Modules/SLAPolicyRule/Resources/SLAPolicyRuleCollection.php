<?php

namespace App\Modules\SLAPolicyRule\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessCollection;

class SLAPolicyRuleCollection extends SuccessCollection
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
