<?php

namespace App\Modules\SLAPolicy\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\SLAPolicy\Contracts\SLAPolicyServiceInterface;
use App\Modules\SLAPolicy\Resources\SLAPolicyResource;
use App\Modules\SLAPolicy\Resources\SLAPolicyCollection;
use App\Modules\SLAPolicy\Requests\SLAPolicyRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class SLAPolicyController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected SLAPolicyServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new SLAPolicyCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new SLAPolicyResource($data);
    }

    public function store(SLAPolicyRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new SLAPolicyResource($data, $messages='SLAPolicy created successfully');
    }

    public function update(SLAPolicyRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new SLAPolicyResource($data, $messages='SLAPolicy updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'SLAPolicy deleted successfully':'SLAPolicy not found',
        ]);
    }
}
