<?php

namespace App\Modules\UserFollows\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\UserFollows\Contracts\UserFollowsServiceInterface;
use App\Modules\UserFollows\Resources\UserFollowsResource;
use App\Modules\UserFollows\Resources\UserFollowsCollection;
use App\Modules\UserFollows\Requests\UserFollowsRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class UserFollowsController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected UserFollowsServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new UserFollowsCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new UserFollowsResource($data);
    }

    public function store(UserFollowsRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new UserFollowsResource($data, $messages='UserFollows created successfully');
    }

    public function update(UserFollowsRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new UserFollowsResource($data, $messages='UserFollows updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'UserFollows deleted successfully':'UserFollows not found',
        ]);
    }
}
