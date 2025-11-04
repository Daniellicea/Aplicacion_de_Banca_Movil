<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Layouts;
use App\Http\Controllers\Support;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login.form');
});

//  Invitados
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Rutas protegidas
Route::middleware('auth.session')->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Layouts
    Route::get('/layouts/app', [Layouts::class, 'app'])->name('app');
    Route::get('/layouts/cards', [Layouts::class, 'card'])->name('layouts.cards');

    // Soporte
    Route::get('/support', [Support::class, 'support'])->name('support');

    // Transacciones
    Route::get('/transactions/loans', [TransactionsController::class, 'loans'])->name('transactions.loans');
    Route::get('/transactions/transfer', [TransactionsController::class, 'transfer'])->name('transactions.transfer');
    Route::post('/transactions/transfer', [TransactionsController::class, 'store'])->name('transfers.store');

    Route::get('/transactions/qr-payments', [TransactionsController::class, 'qr'])->name('transactions.qr');
    Route::post('/transactions/qr-payments', [TransactionsController::class, 'generateQr'])->name('qr-payments.generate');

    // PERFIL DEL USUARIO
    Route::get('/mi-perfil', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/mi-perfil', [UserController::class, 'updateProfile'])->name('users.update_profile');
    Route::put('/mi-perfil/password', [UserController::class, 'updatePassword'])->name('users.update_password');
    Route::delete('/mi-perfil', [UserController::class, 'destroyAccount'])->name('users.destroy_account');

    // Página cuenta (del dashboard card)
    Route::get('/users/account', [UserController::class, 'account'])->name('users.account');

    // Administración de usuarios (manteniendo el plural)
    Route::resource('usuarios', UserController::class)->names('usuarios');
});

// Página pública de seguridad
Route::get('/security', [AuthController::class, 'security'])->name('security');
