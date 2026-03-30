<?php

namespace App\Modules\ArticleComments\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\ArticleComments\Contracts\ArticleCommentsServiceInterface;
use App\Modules\ArticleComments\Resources\ArticleCommentsResource;
use App\Modules\ArticleComments\Resources\ArticleCommentsCollection;
use App\Modules\ArticleComments\Requests\ArticleCommentsRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ArticleCommentsController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected ArticleCommentsServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new ArticleCommentsCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new ArticleCommentsResource($data);
    }

    public function store(ArticleCommentsRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new ArticleCommentsResource($data, $messages='ArticleComments created successfully');
    }

    public function update(ArticleCommentsRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new ArticleCommentsResource($data, $messages='ArticleComments updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'ArticleComments deleted successfully':'ArticleComments not found',
        ]);
    }
}
