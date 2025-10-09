<?php

namespace App\Modules\TopicArticle\Resources;

use App\Modules\TopicCategory\Resources\TopicCategoryResource;
use App\Modules\TopicSection\Resources\TopicSectionResource;
use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;
class TopicArticleResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'description' => $this->description,
            'content' => $this->content,
            'isMarked' => $this->is_marked,
            'topicSectionId' => $this->topic_section_id,
            'authorId' => $this->author_id,
            'publishedAt' => $this->published_at,
            'topicSection' => TopicSectionResource::make($this->whenLoaded('topic_section')),
            'topicCategory' => TopicCategoryResource::make($this->whenLoaded('topic_category')),
            // 'topicArticles' => TopicArticleResource::collection($this->whenLoaded('topic_articles')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
