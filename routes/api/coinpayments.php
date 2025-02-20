<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoinPaymentsController;

// Get exchange rates
Route::get('/coinpayments/rates', [CoinPaymentsController::class, 'getRates']);

// Convert crypto (swap)
Route::post('/coinpayments/convert', [CoinPaymentsController::class, 'convert']);

// Get convert limits
Route::get('/coinpayments/getConvertLimits', [CoinPaymentsController::class, 'getConvertLimits']);

// Get Transaction status
Route::post('/coinpayments/getTransactionStatus', [CoinPaymentsController::class, 'getTransactionStatus']);

// create your coin withdrawal on successfull transaction of user to coinpayment
Route::get('/coinpayments/createWithdrawal', [CoinPaymentsController::class, 'createWithdrawal']);

// handleIPN
Route::post('/coinpayments/handleIPN', [CoinPaymentsController::class, 'handleIPN']);

//createUSDTTransaction
Route::post('/coinpayments/createUSDTTransaction', [CoinPaymentsController::class, 'createUSDTTransaction']);

//getAllTransactions
Route::get('/coinpayments/getAllTransactions', [CoinPaymentsController::class, 'getAllTransactions']);




