<?php

declare(strict_types=1);

namespace App\Services\MoneyTransfer;

use App\Enum\TransferHistoryTypeEnum;
use App\Models\Wallet\Wallet;
use App\Services\Currency\CurrencyService;
use App\Services\TransferHistory\TransferHistoryService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MoneyTransferService
{
    /**
     * @param CurrencyService $currencyService
     * @param TransferHistoryService $historyService
     */
    public function __construct(
        protected CurrencyService        $currencyService,
        protected TransferHistoryService $historyService
    )
    {
    }

    /**
     * @param array $data
     * @return void
     *
     * @throws \Exception
     */
    public function transfer(array $data): void
    {
        $amount = Arr::get($data, 'amount');
        $currency = Arr::get($data, 'currency_code');
        $fromWallet = Wallet::query()->find(Arr::get($data, 'from_wallet_id'));
        $toWallet = Wallet::query()->find(Arr::get($data, 'to_wallet_id'));

        $writeOff = $this->currencyService->convert($amount, $currency, $fromWallet->currency->code);
        $replenish = $this->currencyService->convert($amount, $currency, $toWallet->currency->code);

        try {
            DB::beginTransaction();
            $fromWallet->update(['balance' => $fromWallet->balance - $writeOff]);
            $toWallet->update(['balance' => $toWallet->balance + $replenish]);

            $this->historyService->store($fromWallet, $amount, $currency, TransferHistoryTypeEnum::WriteOff);
            $this->historyService->store($toWallet, $amount, $currency, TransferHistoryTypeEnum::Replenish);
            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            throw new \Exception('Funds transfer error');
        }
    }
}
