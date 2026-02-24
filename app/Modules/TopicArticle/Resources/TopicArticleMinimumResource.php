<?php

namespace App\Modules\TopicArticle\Resources;

use App\Modules\RelatedArticle\Resources\RelatedArticleResource;
use App\Modules\TopicCategory\Resources\TopicCategoryResource;
use App\Modules\TopicSection\Resources\TopicSectionResource;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Request;

use App\Http\Resources\SuccessResource;
class TopicArticleMinimumResource extends SuccessResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
        ];
    }
}
