<?php

namespace App\Models\Currency;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'rate',
        'rounding'
    ];

    /**
     * @var array
     */
    protected $visible = [
        'id',
        'code',
    ];
}
