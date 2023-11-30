<?php

namespace Database\Seeders;

use App\Enum\CurrencyEnum;
use App\Models\Currency\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class CurrencySeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $currencies = array_values(array_column(CurrencyEnum::cases(), 'value'));
        foreach ($currencies as $currency) {
            Currency::query()->firstOrCreate(['code' => $currency]);
            Currency::query()->where('code', $currency)
                ->updateOrCreate(
                    [],
                    [
                        'code' => $currency,
                        'rounding' => Config::get("currency.rounding.{$currency}", 8),
                    ]
                );
        }

        Artisan::call('app:update-exchange-rates-command');
    }
}
