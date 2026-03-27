<?php

namespace App\Modules\TicketMaster\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TicketMaster\Contracts\TicketMasterServiceInterface;
use App\Modules\TicketMaster\Resources\TicketMasterResource;
use App\Modules\TicketMaster\Resources\TicketMasterCollection;
use App\Modules\TicketMaster\Requests\TicketMasterRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TicketMasterController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TicketMasterServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TicketMasterCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TicketMasterResource($data);
    }

    public function store(TicketMasterRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TicketMasterResource($data, $messages='TicketMaster created successfully');
    }

    public function update(TicketMasterRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TicketMasterResource($data, $messages='TicketMaster updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TicketMaster deleted successfully':'TicketMaster not found',
        ]);
    }
}
