<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');



Route::middleware('auth')->group(function () {

    // Route::get('/profile', [UserController::class, 'show']);

    Route::controller(UserController::class)->group(function () {
        Route::get('/all-user', 'index')->name('users.index');
        Route::get('/users/{id}', 'show')->name('users.show');
    });



    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transactions', 'index')->name('transactions.index');
        Route::get('/deposit', 'showDeposits')->name('deposit.show');
        Route::get('/deposit/form', function () {
            return view('transactions.deposit_form');
        })->name('deposit.form');
        Route::post('/deposit/form', 'deposit')->name('deposit.create');


        Route::get('/withdrawal', 'showWithdrawals')->name('withdrawal.show');
        Route::get('/withdrawal/form', function () {
            return view('transactions.withdrawal_form');
        })->name('withdrawal.form');

        Route::post('/withdrawal/form', 'withdraw')->name('withdraw.create');
    });
});
