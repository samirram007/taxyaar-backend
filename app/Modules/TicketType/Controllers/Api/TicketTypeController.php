<?php

namespace App\Modules\TicketType\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\TicketType\Contracts\TicketTypeServiceInterface;
use App\Modules\TicketType\Resources\TicketTypeResource;
use App\Modules\TicketType\Resources\TicketTypeCollection;
use App\Modules\TicketType\Requests\TicketTypeRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class TicketTypeController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected TicketTypeServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new TicketTypeCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new TicketTypeResource($data);
    }

    public function store(TicketTypeRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new TicketTypeResource($data, $messages='TicketType created successfully');
    }

    public function update(TicketTypeRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new TicketTypeResource($data, $messages='TicketType updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'TicketType deleted successfully':'TicketType not found',
        ]);
    }
}
