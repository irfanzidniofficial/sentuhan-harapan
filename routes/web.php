<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonaturController;
use App\Http\Controllers\FundraiserController;
use App\Http\Controllers\FundraisingController;
use App\Http\Controllers\FundraisingPhaseController;
use App\Http\Controllers\FundraisingWithdrawalController;
use App\Http\Controllers\ProfileController;
use App\Models\FundraisingWithdrawal;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class)
        ->middleware('role:owner');

        Route::resource('donaturs', DonaturController::class)
        ->middleware('role:owner');

        Route::get('fundraisers', [FundraiserController::class, 'index'])
        ->name('fundraisers.index');

        Route::resource('fundraisers', FundraiserController::class)
        ->middleware('role:owner')->except('index');

        Route::resource('fundraising_withdrawals', FundraisingWithdrawalController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraising_withdrawals/request/{fundraising}', [FundraisingWithdrawalController::class])->middleware('role:fundraiser')->name('fundraising_withdrawals.store');

        Route::resource('fundraising_phases', FundraisingPhaseController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraising_phases/update/{fundraising}', [FundraisingWithdrawalController::class, 'store'])->middleware('role:fundraiser')->name('fundraising_phases.store');

        Route::resource('fundraising', FundraisingController::class)
        ->middleware('role:owner|fundraiser');

        Route::post('/fundraising/active/{fundraising}', [FundraisingController::class, 'activate_fundraising'])->middleware('role:owner')->name('fundraising_withdrawals.active_fundraising');


        Route::post('/fundraiser/apply', [DashboardController::class, 'apply_fundraiser'])->name('fundraiser.apply');

        Route::get('/my-withdrawals', [DashboardController::class, 'my-withdrawals'])->name('my-withdrawals');

        Route::get('/my-withdrawals/detail/{fundraisingWithdrawal}', [DashboardController::class, 'my-withdrawals'])->name('my-withdrawals.details');

    });

});

require __DIR__.'/auth.php';
