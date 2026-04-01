<?php

namespace App\Modules\TopicComment\Resources;

use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;

class TopicCommentResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user?->name,
            'comment' => $this->comment,
            'status' => $this->status,
            'createdAt' => $this->created_at?->toISOString()
        ];
    }
}