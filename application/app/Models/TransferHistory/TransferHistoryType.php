<?php

namespace App\Models\TransferHistory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferHistoryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name'
    ];

    protected $visible = [
        'id',
        'code',
        'name'
    ];
}
