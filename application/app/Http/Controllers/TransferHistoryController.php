<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferHistory\IndexRequest;
use App\Http\Resources\TransferHistory\TransferHistoryResource;
use App\Services\TransferHistory\TransferHistoryService;
use Exception;
use Illuminate\Http\JsonResponse;

class TransferHistoryController extends Controller
{

    /**
     * @param TransferHistoryService $service
     */
    public function __construct(protected TransferHistoryService $service)
    {
    }

    /**
     * @param IndexRequest $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function __invoke(IndexRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $histories = $this->service->list($attributes);

        return TransferHistoryResource::collection($histories)->response();
    }
}
