<?php

declare(strict_types=1);

namespace App\Services\TransferHistory;

use App\Enum\TransferHistoryTypeEnum;
use App\Models\Currency\Currency;
use App\Models\TransferHistory\TransferHistory;
use App\Models\TransferHistory\TransferHistoryType;
use App\Models\Wallet\Wallet;
use App\Services\Paginator\PaginatorService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class TransferHistoryService
{
    /**
     * @param PaginatorService $paginatorService
     */
    public function __construct(protected PaginatorService $paginatorService)
    {
    }

    /**
     * @param array $data
     *
     * @return Paginator
     */
    public function list(array $data): Paginator
    {
        $query = TransferHistory::query()->with(['currency', 'type', 'wallet.currency']);

        $walletId = Arr::get($data, 'wallet_id');
        $query->when($walletId, fn(Builder $q) => $q->where('wallet_id', $walletId));

        return $this->paginatorService->sort($query, $data)->paginate($query, $data);

    }

    /**
     * @param Wallet $wallet
     * @param float $amount
     * @param string $currencyCode
     * @param TransferHistoryTypeEnum $typeEnum
     *
     * @return TransferHistory
     */
    public function store(
        Wallet $wallet,
        float $amount,
        string $currencyCode,
        TransferHistoryTypeEnum $typeEnum): TransferHistory {

        $type = TransferHistoryType::query()->where('code', $typeEnum->value)->first();
        $currency = Currency::query()->where('code', $currencyCode)->first();

        $data = [
            'wallet_id' => $wallet->id,
            'type_id' => $type->id,
            'currency_id' => $currency->id,
            'amount' => $amount,
            'balance' => $wallet->balance
        ];

        return TransferHistory::query()->create($data);
    }
}
