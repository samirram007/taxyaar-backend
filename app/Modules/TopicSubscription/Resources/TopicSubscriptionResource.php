<?php

namespace App\Modules\TopicSubscription\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;

class TopicSubscriptionResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
