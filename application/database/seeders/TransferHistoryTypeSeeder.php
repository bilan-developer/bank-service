<?php

namespace Database\Seeders;

use App\Enum\TransferHistoryTypeEnum;
use App\Models\TransferHistory\TransferHistoryType;
use Illuminate\Database\Seeder;

class TransferHistoryTypeSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $types = array_values(array_column(TransferHistoryTypeEnum::cases(), 'value'));
        foreach ($types as $type) {
            TransferHistoryType::query()->where('code', $type)
                ->updateOrCreate(
                    [],
                    [
                        'code' => $type,
                        'name' => trans(key: "transfer_history_type.{$type}", locale: 'en'),
                    ]
                );
        }
    }
}
