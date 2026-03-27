<?php

namespace App\Modules\TicketEventType\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TicketEventType\Contracts\TicketEventTypeServiceInterface;
use App\Modules\TicketEventType\Resources\TicketEventTypeResource;
use App\Modules\TicketEventType\Resources\TicketEventTypeCollection;
use App\Modules\TicketEventType\Requests\TicketEventTypeRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TicketEventTypeController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TicketEventTypeServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TicketEventTypeCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TicketEventTypeResource($data);
    }

    public function store(TicketEventTypeRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TicketEventTypeResource($data, $messages='TicketEventType created successfully');
    }

    public function update(TicketEventTypeRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TicketEventTypeResource($data, $messages='TicketEventType updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TicketEventType deleted successfully':'TicketEventType not found',
        ]);
    }
}
