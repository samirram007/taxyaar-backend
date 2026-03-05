<?php

namespace App\Modules\Client\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Client\Contracts\ClientServiceInterface;
use App\Modules\Client\Resources\ClientResource;
use App\Modules\Client\Resources\ClientCollection;
use App\Modules\Client\Requests\ClientRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected ClientServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new ClientCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new ClientResource($data);
    }

    public function store(ClientRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new ClientResource($data, $messages='Client created successfully');
    }

    public function update(ClientRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new ClientResource($data, $messages='Client updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'Client deleted successfully':'Client not found',
        ]);
    }
}
