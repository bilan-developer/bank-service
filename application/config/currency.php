<?php

use App\Enum\CurrencyEnum;

return [
    'url' => 'https://api.coingate.com/api/v2/rates/merchant/',
    'default' => CurrencyEnum::USD->value,
    'rounding' => [
        CurrencyEnum::EUR->value => 2,
        CurrencyEnum::USD->value => 2,
        CurrencyEnum::BTC->value => 8,
    ]
];
