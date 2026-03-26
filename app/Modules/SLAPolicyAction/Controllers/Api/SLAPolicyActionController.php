<?php

namespace App\Modules\SLAPolicyAction\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\SLAPolicyAction\Contracts\SLAPolicyActionServiceInterface;
use App\Modules\SLAPolicyAction\Resources\SLAPolicyActionResource;
use App\Modules\SLAPolicyAction\Resources\SLAPolicyActionCollection;
use App\Modules\SLAPolicyAction\Requests\SLAPolicyActionRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class SLAPolicyActionController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected SLAPolicyActionServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new SLAPolicyActionCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new SLAPolicyActionResource($data);
    }

    public function store(SLAPolicyActionRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new SLAPolicyActionResource($data, $messages='SLAPolicyAction created successfully');
    }

    public function update(SLAPolicyActionRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new SLAPolicyActionResource($data, $messages='SLAPolicyAction updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'SLAPolicyAction deleted successfully':'SLAPolicyAction not found',
        ]);
    }
}
