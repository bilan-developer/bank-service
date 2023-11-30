<?php

declare(strict_types=1);

namespace App\Enum;

enum TransferHistoryTypeEnum: string
{
    case WriteOff = 'write_off';
    case Replenish = 'replenish';
}
