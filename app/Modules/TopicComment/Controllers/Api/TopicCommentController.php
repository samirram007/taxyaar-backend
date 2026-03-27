<?php

namespace App\Modules\TopicComment\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TopicComment\Contracts\TopicCommentServiceInterface;
use App\Modules\TopicComment\Resources\TopicCommentResource;
use App\Modules\TopicComment\Resources\TopicCommentCollection;
use App\Modules\TopicComment\Requests\TopicCommentRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TopicCommentController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TopicCommentServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TopicCommentCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TopicCommentResource($data);
    }

    public function store(TopicCommentRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TopicCommentResource($data, $messages='TopicComment created successfully');
    }

    public function update(TopicCommentRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TopicCommentResource($data, $messages='TopicComment updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TopicComment deleted successfully':'TopicComment not found',
        ]);
    }
}
