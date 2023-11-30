<?php

namespace App\Http\Controllers;

use App\Models\Currency\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        return JsonResource::collection(Currency::all())->response();
    }
}
