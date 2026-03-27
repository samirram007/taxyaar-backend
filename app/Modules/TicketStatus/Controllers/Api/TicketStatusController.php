<?php

namespace App\Modules\TicketStatus\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TicketStatus\Contracts\TicketStatusServiceInterface;
use App\Modules\TicketStatus\Resources\TicketStatusResource;
use App\Modules\TicketStatus\Resources\TicketStatusCollection;
use App\Modules\TicketStatus\Requests\TicketStatusRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TicketStatusController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TicketStatusServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TicketStatusCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TicketStatusResource($data);
    }

    public function store(TicketStatusRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TicketStatusResource($data, $messages='TicketStatus created successfully');
    }

    public function update(TicketStatusRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TicketStatusResource($data, $messages='TicketStatus updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TicketStatus deleted successfully':'TicketStatus not found',
        ]);
    }
}
