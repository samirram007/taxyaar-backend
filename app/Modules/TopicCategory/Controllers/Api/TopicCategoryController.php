<?php

namespace App\Modules\TopicCategory\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TopicCategory\Contracts\TopicCategoryServiceInterface;
use App\Modules\TopicCategory\Resources\TopicCategoryResource;
use App\Modules\TopicCategory\Resources\TopicCategoryCollection;
use App\Modules\TopicCategory\Requests\TopicCategoryRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TopicCategoryController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TopicCategoryServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TopicCategoryCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TopicCategoryResource($data);
    }

    public function store(TopicCategoryRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TopicCategoryResource($data, $messages='TopicCategory created successfully');
    }

    public function update(TopicCategoryRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TopicCategoryResource($data, $messages='TopicCategory updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TopicCategory deleted successfully':'TopicCategory not found',
        ]);
    }
}
