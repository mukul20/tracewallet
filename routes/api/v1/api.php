<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\{
	TransactionController,
	WalletController,
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('transactions', [TransactionController::class , 'index'])
	->name('transactions.index');

Route::get('wallet/{walletAddress}', [WalletController::class , 'show'])
    ->name('wallet.show');

Route::get('wallet/{walletAddress}/balance', [WalletController::class , 'getHistoricalBalance'])
    ->name('wallet.balance');

