<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(TransferHistoryTypeSeeder::class);
    }
}
