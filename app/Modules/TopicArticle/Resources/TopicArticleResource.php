<?php

namespace App\Modules\TopicArticle\Resources;

use App\Modules\RelatedArticle\Resources\RelatedArticleResource;
use App\Modules\TopicCategory\Resources\TopicCategoryResource;
use App\Modules\TopicSection\Resources\TopicSectionResource;
use App\Modules\User\Resources\UserResource;
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
            'relatedArticles' => TopicArticleMinimumResource::collection($this->whenLoaded('relatedArticles')),
            // 'relatedArticles' => RelatedArticleResource::collection($this->whenLoaded('related_articles')),
            // 'topicArticles' => TopicArticleResource::collection($this->whenLoaded('topic_articles')),
            'createdAt' => $this->created_at?->toISOString(),
            'updatedAt' => $this->updated_at?->toISOString(),
            'creator' => UserResource::make($this->whenLoaded('creator')),
            'updater' => UserResource::make($this->whenLoaded('updater')),
        ];
    }
}
