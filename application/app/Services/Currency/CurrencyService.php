<?php

declare(strict_types=1);

namespace App\Services\Currency;

use App\Models\Currency\Currency;
use Exception;

class CurrencyService
{
    /**
     * @param mixed $amount
     * @param string $currencyFrom
     * @param string $currencyTo
     *
     * @return float
     * @throws Exception
     */
    public function convert(mixed $amount, string $currencyFrom, string $currencyTo): float
    {
        if ($currencyFrom === $currencyTo) {
            return $amount;
        }

        $fromRate = $this->getCurrency($currencyFrom)->rate;
        $toRate = $this->getCurrency($currencyTo)->rate;

        try {
            return ($amount * $fromRate) / $toRate;
        } catch (Exception $e) {
            throw new Exception('Error converting currency');
        }

        return $value;
    }

    /**
     * @param string $code
     *
     * @return Currency
     */
    public function getCurrency(string $code): Currency
    {
        return Currency::query()->where('code', $code)->firstOrFail();
    }
}
