<?php

declare(strict_types=1);

use App\Enum\TransferHistoryTypeEnum;

return [
    TransferHistoryTypeEnum::WriteOff->value => 'Write Off',
    TransferHistoryTypeEnum::Replenish->value => 'Replenish',
];

