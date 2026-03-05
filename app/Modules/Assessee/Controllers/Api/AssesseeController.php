<?php

namespace App\Modules\Assessee\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Assessee\Contracts\AssesseeServiceInterface;
use App\Modules\Assessee\Resources\AssesseeResource;
use App\Modules\Assessee\Resources\AssesseeCollection;
use App\Modules\Assessee\Requests\AssesseeRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class AssesseeController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected AssesseeServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new AssesseeCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new AssesseeResource($data);
    }

    public function store(AssesseeRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new AssesseeResource($data, $messages='Assessee created successfully');
    }

    public function update(AssesseeRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new AssesseeResource($data, $messages='Assessee updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'Assessee deleted successfully':'Assessee not found',
        ]);
    }
}
