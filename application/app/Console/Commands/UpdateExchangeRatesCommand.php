<?php

namespace App\Console\Commands;

use App\Enum\CurrencyEnum;
use App\Models\Currency\Currency;
use App\Services\Currency\HttpClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class UpdateExchangeRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-exchange-rates-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates';

    /**
     * @param HttpClient $client
     *
     * @return void
     */
    public function __construct(private HttpClient $client)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currencies = array_values(array_column(CurrencyEnum::cases(), 'value'));
        $currencyDefault = Config::get('currency.default');
        foreach ($currencies as $currency) {
            $rate = $this->client->request(sprintf("%s/%s", $currency, $currencyDefault));
            Currency::query()
                ->where('code', $currency)
                ->update(['rate' => $rate]);
        }
    }
}
