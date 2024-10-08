<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectsController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\BlockchainTransferController;
use App\Http\Controllers\InvestmentsController;
use App\Http\Controllers\ReferralLevelsController;
use App\Http\Controllers\SwapController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminTransactionsController;


use Illuminate\Support\Facades\Route;

// Dashboard and Authenticated User Routes
Route::prefix('user')->group(function () {

    Route::middleware(['auth'])->group(function () {
        // DashboardController routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // WalletController routes
        Route::get('/directs', [DirectsController::class, 'index'])->name('directs');

        // WalletController routes
        Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
        Route::post('/wallet', [WalletController::class, 'transferRewardToAvailable'])->name('wallet.transferRewardToAvailable');

        // TransferController routes
        Route::get('/wallet/transfer', [TransferController::class, 'transfer'])->name('wallet.transfer');
        Route::post('/wallet/sendOtp', [TransferController::class, 'sendOtp'])->name('wallet.sendOtp');
        Route::post('/wallet/validateTransfer', [TransferController::class, 'validateTransfer'])->name('wallet.validateTransfer');
        Route::post('/wallet/completeTransfer', [TransferController::class, 'completeTransfer'])->name('wallet.completeTransfer');
        Route::get('/dashboard/levels/{level}', [ReferralLevelsController::class, 'showLevelDetails'])->name('levels.show');

        Route::get('/wallet/withdraw', [BlockchainTransferController::class, 'withdraw'])->name('wallet.withdraw');
        Route::get('/wallet/validatewithdraw', [BlockchainTransferController::class, 'validateWithdraw'])->name('wallet.validateWithdraw');
        Route::post('/wallet/completewithdraw', [BlockchainTransferController::class, 'completewithdraw'])->name('wallet.completewithdraw');





        // InvestmentsController routes
        Route::get('/investments', [InvestmentsController::class, 'index'])->name('investments.index');
        Route::post('/unstake', [InvestmentsController::class, 'processUnstake'])->name('unstake.process');
        Route::post('/unstake/confirm', [InvestmentsController::class, 'confirmUnstake'])->name('unstake.confirm');
        Route::post('/stake', [InvestmentsController::class, 'processStake'])->name('stake.process');
        Route::post('/stake/confirm', [InvestmentsController::class, 'confirmStake'])->name('stake.confirm');

        // Swap controllers route
        Route::get('/swap', [SwapController::class, 'index'])->name('swap.index');
        Route::get('/swap/processSwap', [SwapController::class, 'processSwap'])->name('swap.process');
        Route::get('/swap/confirm', [SwapController::class, 'processConfirm'])->name('swap.confirm');

        // Profile controller
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update-name', [ProfileController::class, 'updateName'])->name('update.name');
        Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        Route::post('/profile/update-wallet', [ProfileController::class, 'updateWallet']);


        // Activities controller
        Route::get('/activities', [ActivitiesController::class, 'show'])->name('activities.show');



        // Adding logout here ensures that only authenticated users can access it
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
    // Guest Routes
    Route::middleware(['guest'])->group(function () {
        Route::get('/', function () {
            return redirect()->route('login'); // Redirect user to login page
        });
        Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AuthController::class, 'register'])->name('register.post');

        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.post');

        // Route to display the password reset request form
        Route::get('/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.reset');

        // Route to display the password reset form with token and email parameters
        Route::get('/email', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
        Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('password.update');



    });

    Route::prefix('team')->name('admin.')->group(function () {
        Route::middleware('admin.guest')->group(function () {
            Route::get('/login', [AdminAuthController::class, 'showAdminLoginForm'])->name('login');
            Route::post('/login', [AdminAuthController::class, 'adminLogin'])->name('login.post');
        });

        Route::middleware('admin.auth')->group(function () {
            // admin dashboard routes
            Route::post('/logout', [AdminAuthController::class, 'adminLogout'])->name('logout');
            Route::get('/dashboard', [AdminDashboardController::class, 'adminDashboard'])->name('dashboard');

            Route::get('/users', [AdminUsersController::class, 'userListShow'])->name('users');
            Route::get('/users/search', [AdminUsersController::class, 'userListShow'])->name('user.list');
            Route::get('/admin/users/info/{id}', [AdminUsersController::class, 'infoUser'])->name('user.info');

            Route::get('/transactions', [AdminTransactionsController::class, 'showTransactions'])->name('transactions');
            Route::post('/transactions/update', [AdminTransactionsController::class, 'updateTransaction'])->name('transactions.update');


            Route::get('/admin/user/{id}/edit', [AdminUsersController::class, 'edit'])->name('user.edit');
            Route::put('/admin/user/{id}', [AdminUsersController::class, 'update'])->name('user.update');

        });
    });



// Fallback Route for handling 404
Route::fallback(function () {
    return view('errors.guest404');
});
