<?php

namespace App\Modules\TicketEvent\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TicketEvent\Contracts\TicketEventServiceInterface;
use App\Modules\TicketEvent\Resources\TicketEventResource;
use App\Modules\TicketEvent\Resources\TicketEventCollection;
use App\Modules\TicketEvent\Requests\TicketEventRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TicketEventController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TicketEventServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TicketEventCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TicketEventResource($data);
    }

    public function store(TicketEventRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TicketEventResource($data, $messages='TicketEvent created successfully');
    }

    public function update(TicketEventRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TicketEventResource($data, $messages='TicketEvent updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TicketEvent deleted successfully':'TicketEvent not found',
        ]);
    }
}
