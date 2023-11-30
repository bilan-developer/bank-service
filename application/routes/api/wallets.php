<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;


Route::resource('wallets', WalletController::class)->only(['index', 'store']);
Route::patch('/wallets/{wallet}/replenish', [WalletController::class, 'replenish'])
    ->name('wallets.replenish');

Route::patch('/wallets/transfers', [WalletController::class, 'replenish'])
    ->name('wallets.replenish');

