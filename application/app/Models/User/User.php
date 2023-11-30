<?php

namespace App\Models\User;

use App\Models\Wallet\Wallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;

    public const SORTABLE_FIELDS = [
        'name',
        'age',
        'email'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'age',
        'email',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * @return HasMany
     */
    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }
}
