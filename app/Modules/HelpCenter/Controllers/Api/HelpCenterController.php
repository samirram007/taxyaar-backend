<?php

namespace App\Modules\HelpCenter\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\HelpCenter\Contracts\HelpCenterServiceInterface;
use App\Modules\HelpCenter\Resources\HelpCenterResource;
use App\Modules\HelpCenter\Resources\HelpCenterCollection;
use App\Modules\HelpCenter\Requests\HelpCenterRequest;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\SuccessCollection;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;

class HelpCenterController extends Controller
{
    use ApiResponseTrait;

    public function __construct(protected HelpCenterServiceInterface $service) {}

    public function index(): SuccessCollection
    {
        $data = $this->service->getAll();
        return new HelpCenterCollection($data);
    }

    public function show(int $id): SuccessResource
    {
        $data = $this->service->getById($id);
        return  new HelpCenterResource($data);
    }

    public function store(HelpCenterRequest $request): SuccessResource
    {
        $data = $this->service->store($request->validated());
       return  new HelpCenterResource($data, $messages='HelpCenter created successfully');
    }

    public function update(HelpCenterRequest $request, int $id): SuccessResource
    {
        $data = $this->service->update($request->validated(), $id);
        return  new HelpCenterResource($data, $messages='HelpCenter updated successfully');
    }

        public function destroy(int $id): JsonResponse
    {

        $result=$this->service->delete($id);
        return new JsonResponse([
            'status' => $result,
            'code' => 204,
            'message' => $result?'HelpCenter deleted successfully':'HelpCenter not found',
        ]);
    }
}
