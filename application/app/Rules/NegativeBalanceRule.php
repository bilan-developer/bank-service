<?php

namespace App\Rules;

use App\Models\Wallet\Wallet;
use App\Services\Currency\CurrencyService;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\App;

class NegativeBalanceRule implements ValidationRule
{
    /**
     * @param mixed $code
     * @param mixed $amount
     */
    public function __construct(protected mixed $code, protected mixed $amount)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     *
     * @throws Exception
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var CurrencyService $currencyService */
        $currencyService = App::make(CurrencyService::class);

        /** @var Wallet $wallet */
        $wallet = Wallet::query()->find($value);
        if ($wallet && $this->code && $this->amount) {
            $convertAmount = $currencyService->convert($this->amount, $this->code, $wallet->currency->code);
            $diff = $wallet->balance - $convertAmount;
            if ($diff < 0) {
                $fail(trans('validation.custom.negative-balance'));
            }
        }
    }
}
