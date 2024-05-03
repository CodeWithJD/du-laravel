<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectsController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\InvestmentsController;
use App\Http\Controllers\ReferralLevelsController;
use Illuminate\Support\Facades\Route;

// Dashboard and Authenticated User Routes
Route::middleware(['auth'])->group(function () {

    // DashboardController routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // WalletController routes
    Route::get('/directs', [DirectsController::class, 'index'])->name('directs');

    // WalletController routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');

    // TransferController routes
    Route::get('/wallet/transfer', [TransferController::class, 'transfer'])->name('wallet.transfer');
    Route::post('/wallet/validateTransfer', [TransferController::class, 'validateTransfer'])->name('wallet.validateTransfer');
    Route::post('/wallet/completeTransfer', [TransferController::class, 'completeTransfer'])->name('wallet.completeTransfer');
    Route::get('/dashboard/levels/{level}', [ReferralLevelsController::class, 'showLevelDetails'])->name('levels.show');

    // InvestmentsController routes
    Route::get('/investments', [InvestmentsController::class, 'index'])->name('investments.index');
    Route::post('/unstake', [InvestmentsController::class, 'processUnstake'])->name('unstake.process');
    Route::post('/unstake/confirm', [InvestmentsController::class, 'confirmUnstake'])->name('unstake.confirm');
    Route::post('/stake', [InvestmentsController::class, 'processStake'])->name('stake.process');
    Route::post('/stake/confirm', [InvestmentsController::class, 'confirmStake'])->name('stake.confirm');



    // Adding logout here ensures that only authenticated users can access it
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Guest Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('website.home');
    });
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register.post');

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});

// Fallback Route for handling 404
Route::fallback(function () {
    return view('errors.guest404');
});
