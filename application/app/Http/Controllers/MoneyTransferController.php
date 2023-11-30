<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoneyTransfer\TransferRequest;
use App\Services\MoneyTransfer\MoneyTransferService;
use Exception;
use Illuminate\Http\JsonResponse;

class MoneyTransferController extends Controller
{

    /**
     * @param MoneyTransferService $service
     */
    public function __construct(protected MoneyTransferService $service)
    {
    }

    /**
     * @param TransferRequest $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function __invoke(TransferRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $this->service->transfer($attributes);

        return response()->json();
    }
}
