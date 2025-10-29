<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\home;
use App\Http\Controllers\layouts;
use App\Http\Controllers\support;
use App\Http\Controllers\transactions;
use App\Http\Controllers\user;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas públicas (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Rutas protegidas (auth)
Route::middleware('auth')->group(function () {
    // Cerrar sesión (idealmente POST por seguridad; si usas GET, al menos protégelo con auth)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard / Home
    Route::get('/home', [home::class, 'home'])->name('home');
    Route::get('/dashboard', [home::class, 'home'])->name('dashboard');

    // Layouts
    Route::get('/layouts/app', [layouts::class, 'app'])->name('app');
    Route::get('/layouts/cards', [layouts::class, 'card'])->name('layouts.cards');

    // Soporte
    Route::get('/support', [support::class, 'support'])->name('support');

    // Transacciones
    Route::get('/transactions/loans', [transactions::class, 'loans'])->name('transactions.loans');
    Route::get('/transactions/transfer', [transactions::class, 'transfer'])->name('transactions.transfer');
    Route::post('/transactions/transfer', [transactions::class, 'store'])->name('transactions.transfer.store');

    // QR Payments (deja **una** ruta GET con **un** nombre)
    Route::get('/transactions/qr-payments', [transactions::class, 'qr'])->name('transactions.qr');
    Route::post('/transactions/qr-payments', [transactions::class, 'generateQr'])->name('transactions.qr.generate');

    // Usuarios / Cuentas
    Route::get('/users/account', [user::class, 'account'])->name('users.account');
    Route::get('/accounts', [user::class, 'account'])->name('accounts');
});

// Seguridad (pública si es una página informativa)
Route::get('/security', [AuthController::class, 'security'])->name('security');
