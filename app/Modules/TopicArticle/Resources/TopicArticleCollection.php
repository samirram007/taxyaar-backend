<?php

namespace App\Modules\TopicArticle\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\SuccessCollection;

class TopicArticleCollection extends SuccessCollection
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
