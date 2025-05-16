<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransactionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $balance = $user->wallet ? $user->wallet->balance : 0;

    return view('dashboard', compact('user', 'balance'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/transfer', [WalletController::class, 'transfer'])->name('wallet.transfer');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/deposit', [TransactionController::class, 'showDepositForm'])->name('deposit.form');
    Route::post('/deposit', [TransactionController::class, 'performDeposit'])->name('deposit.perform');

    Route::get('/transfer', [TransactionController::class, 'showTransferForm'])->name('transfer.form');
    Route::post('/transfer', [TransactionController::class, 'performTransfer'])->name('transfer.perform');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::patch('/transactions/{id}/reverse', [TransactionController::class, 'reverse'])->name('transactions.reverse');
});
require __DIR__ . '/auth.php';
