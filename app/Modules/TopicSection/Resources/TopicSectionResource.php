<?php

namespace App\Modules\TopicSection\Resources;

use App\Modules\TopicArticle\Resources\TopicArticleResource;
use App\Modules\TopicCategory\Resources\TopicCategoryResource;
use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;
class TopicSectionResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status,
            'description' => $this->description,
            'isMarked' => $this->is_marked,
            'topicCategoryId' => $this->topic_category_id,
            'topicCategory' => TopicCategoryResource::make($this->whenLoaded('topic_category')),
            'topicArticles' => TopicArticleResource::collection($this->whenLoaded('topic_articles')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
