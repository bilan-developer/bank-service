<?php

use App\Http\Controllers\MoneyTransferController;
use Illuminate\Support\Facades\Route;


Route::post('/money-transfer', MoneyTransferController::class)
    ->name('money-transfer');

