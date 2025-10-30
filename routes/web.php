<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home;
use App\Http\Controllers\Layouts;
use App\Http\Controllers\Support;
use App\Http\Controllers\Transactions;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::get('/dashboard', [Home::class, 'home'])->name('dashboard');
Route::get('/home', [Home::class, 'home'])->name('home');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/layouts/app', [Layouts::class, 'app'])->name('app');
Route::get('/layouts/cards', [Layouts::class, 'card'])->name('layouts.cards');

Route::get('/support', [Support::class, 'support'])->name('support');

Route::get('/transactions/loans', [Transactions::class, 'loans'])->name('transactions.loans');
Route::get('/transactions/transfer', [Transactions::class, 'transfer'])->name('transactions.transfer');
Route::post('/transactions/transfer', [Transactions::class, 'store'])->name('transfers.store');

Route::get('/transactions/qr-payments', [Transactions::class, 'qr'])->name('transactions.qr');
Route::post('/transactions/qr-payments', [Transactions::class, 'generateQr'])->name('qr-payments.generate');

Route::get('/users/account', [UserController::class, 'account'])->name('users.account');
Route::get('/accounts', [UserController::class, 'account'])->name('accounts');

Route::get('/security', [AuthController::class, 'security'])->name('security');

Route::resource('usuarios', UserController::class)->names('usuarios');
