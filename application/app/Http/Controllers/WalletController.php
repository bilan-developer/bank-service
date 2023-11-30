<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\IndexRequest;
use App\Http\Requests\Wallet\ReplenishRequest;
use App\Http\Requests\Wallet\StoreRequest;
use App\Http\Resources\Wallet\WalletResource;
use App\Models\Wallet\Wallet;
use App\Services\Wallet\WalletService;
use Exception;
use Illuminate\Http\JsonResponse;

class WalletController extends Controller
{
    /**
     * @param WalletService $service
     */
    public function __construct(protected WalletService $service)
    {
    }

    /**
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $wallets = $this->service->list($attributes);
        return WalletResource::collection($wallets)->response();
    }

    /**
     * @param StoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $attributes = $request->validated();
        $wallet = $this->service->store($attributes);

        return (new WalletResource($wallet))->response();
    }

    /**
     * @param ReplenishRequest $request
     * @param Wallet $wallet
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function replenish(ReplenishRequest $request, Wallet $wallet): JsonResponse
    {
        $attributes = $request->validated();
        $wallet = $this->service->replenish($attributes, $wallet);

        return (new WalletResource($wallet))->response();
    }
}
