<?php

namespace App\Modules\TicketPriority\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TicketPriority\Contracts\TicketPriorityServiceInterface;
use App\Modules\TicketPriority\Resources\TicketPriorityResource;
use App\Modules\TicketPriority\Resources\TicketPriorityCollection;
use App\Modules\TicketPriority\Requests\TicketPriorityRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TicketPriorityController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TicketPriorityServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TicketPriorityCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TicketPriorityResource($data);
    }

    public function store(TicketPriorityRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TicketPriorityResource($data, $messages='TicketPriority created successfully');
    }

    public function update(TicketPriorityRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TicketPriorityResource($data, $messages='TicketPriority updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TicketPriority deleted successfully':'TicketPriority not found',
        ]);
    }
}
