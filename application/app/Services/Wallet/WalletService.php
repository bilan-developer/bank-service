<?php

declare(strict_types=1);

namespace App\Services\Wallet;

use App\Enum\TransferHistoryTypeEnum;
use App\Models\Wallet\Wallet;
use App\Services\Currency\CurrencyService;
use App\Services\Paginator\PaginatorService;
use App\Services\TransferHistory\TransferHistoryService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class WalletService
{
    /**
     * @param CurrencyService $currencyService
     * @param PaginatorService $paginatorService
     * @param TransferHistoryService $historyService
     */
    public function __construct(
        protected CurrencyService $currencyService,
        protected PaginatorService $paginatorService,
        protected TransferHistoryService $historyService,
    ) {
    }

    /**
     * @param array $data
     *
     * @return Paginator
     */
    public function list(array $data): Paginator
    {
        $query = Wallet::query();

        $userId = Arr::get($data, 'user_id');
        $query->when($userId, fn(Builder $q) => $q->where('user_id', $userId));

        $currencyId = Arr::get($data, 'currency_id');
        $query->when($currencyId, fn(Builder $q) => $q->where('currency_id', $currencyId));

        return $this->paginatorService->sort($query, $data)->paginate($query, $data);
    }

    /**
     * @param array $attributes
     *
     * @return Wallet
     */
    public function store(array $attributes): Wallet
    {
        return Wallet::query()->firstOrCreate($attributes);
    }

    /**
     * @param mixed $data
     * @param Wallet $wallet
     *
     * @return Wallet
     * @throws \Exception
     */
    public function replenish(mixed $data, Wallet $wallet): Wallet
    {
        $amount = Arr::get($data, 'amount');
        $currency = Arr::get($data, 'currency_code');
        $convertAmount = $this->currencyService->convert($amount, $currency, $wallet->currency->code);

        try {
            $wallet->update(['balance' => $wallet->balance + $convertAmount]);
            $this->historyService->store($wallet, $amount, $currency, TransferHistoryTypeEnum::Replenish);
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            throw new \Exception('Replenishment error');
        }

        return $wallet;
    }
}
