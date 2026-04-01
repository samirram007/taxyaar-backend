<?php

namespace App\Modules\TopicSubscription\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TopicSubscription\Contracts\TopicSubscriptionServiceInterface;
use App\Modules\TopicSubscription\Resources\TopicSubscriptionResource;
use App\Modules\TopicSubscription\Resources\TopicSubscriptionCollection;
use App\Modules\TopicSubscription\Requests\TopicSubscriptionRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TopicSubscriptionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TopicSubscriptionServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TopicSubscriptionCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TopicSubscriptionResource($data);
    }

    public function store(TopicSubscriptionRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TopicSubscriptionResource($data, $messages='TopicSubscription created successfully');
    }

    public function update(TopicSubscriptionRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TopicSubscriptionResource($data, $messages='TopicSubscription updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TopicSubscription deleted successfully':'TopicSubscription not found',
        ]);
    }
}
