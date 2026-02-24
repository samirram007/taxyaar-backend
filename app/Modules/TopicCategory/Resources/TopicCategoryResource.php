<?php

namespace App\Modules\TopicCategory\Resources;

use App\Modules\TopicSection\Models\TopicSection;
use App\Modules\TopicSection\Resources\TopicSectionResource;
use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;
class TopicCategoryResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'description' => $this->description,
            'topicSections' => TopicSectionResource::collection($this->whenLoaded('topic_sections')),
            'icon' => $this->icon,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
