<?php

namespace App\Models\TransferHistory;

use App\Models\Currency\Currency;
use App\Models\Wallet\Wallet;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferHistory extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    public const SORTABLE_FIELDS = [
        'amount',
        'balance',
        'created_at'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'wallet_id',
        'type_id',
        'currency_id',
        'amount',
        'balance'
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
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TransferHistoryType::class, 'type_id');
    }

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Transaction amount.
     *
     * @return Attribute
     */
    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn($value) => round($value, $this->currency->rounding),
        );
    }

    /**
     * Balance at the time of operation.
     *
     * @return Attribute
     */
    public function balance(): Attribute
    {
        return Attribute::make(
            get: fn($value) => round($value, $this->wallet->currency->rounding),
        );
    }
}
