<?php

namespace App\Models\Wallet;

use App\Models\Currency\Currency;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'currency_id',
        'balance',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'balance' => 0,
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return Attribute
     */
    public function balance(): Attribute
    {
        return Attribute::make(
            get: fn($value) => round($value, $this->currency->rounding),
        );
    }
}
