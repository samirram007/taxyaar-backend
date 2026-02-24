<?php

namespace App\Modules\TopicArticle\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TopicArticle\Contracts\TopicArticleServiceInterface;
use App\Modules\TopicArticle\Resources\TopicArticleResource;
use App\Modules\TopicArticle\Resources\TopicArticleCollection;
use App\Modules\TopicArticle\Requests\TopicArticleRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TopicArticleController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TopicArticleServiceInterface $service)
    {
    }

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TopicArticleCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return new TopicArticleResource($data);
    }
    public function getBySlug(string $slug): SuccessResource
    {
        $data = $this->service->getBySlug($slug);
        return new TopicArticleResource($data);
    }

    public function store(TopicArticleRequest $request): SuccessResource
    {

        $data = $this->service->store($request->validated());

        return new TopicArticleResource($data, $messages = 'TopicArticle created successfully');
    }

    public function update(TopicArticleRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return new TopicArticleResource($data, $messages = 'TopicArticle updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {

        $result = $this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result ? 'TopicArticle deleted successfully' : 'TopicArticle not found',
        ]);
    }
}
