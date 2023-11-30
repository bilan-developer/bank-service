<?php

use App\Http\Controllers\TransferHistoryController;
use Illuminate\Support\Facades\Route;


Route::get('/transfer-histories', TransferHistoryController::class)
    ->name('transfer-histories.index');

