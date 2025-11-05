<?php

use Illuminate\Support\Facades\Route;

<<<<<<< Updated upstream
use App\Http\Controllers\AuthController;
use App\Http\Controllers\home;
use App\Http\Controllers\layouts;
use App\Http\Controllers\support;
use App\Http\Controllers\transactions;
use App\Http\Controllers\user;
=======
// ✅ Controladores renombrados
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
>>>>>>> Stashed changes

// Redirigir al login
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

<<<<<<< Updated upstream
// Rutas públicas (guest)
=======
// Invitados (no logueados)
>>>>>>> Stashed changes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

<<<<<<< Updated upstream
// Rutas protegidas (auth)
Route::middleware('auth')->group(function () {
    // Cerrar sesión (idealmente POST por seguridad; si usas GET, al menos protégelo con auth)
=======
// Rutas protegidas (logueado)
Route::middleware('auth.session')->group(function () {

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    // Logout
>>>>>>> Stashed changes
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard / Home
    Route::get('/home', [home::class, 'home'])->name('home');
    Route::get('/dashboard', [home::class, 'home'])->name('dashboard');

    // Layouts
<<<<<<< Updated upstream
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
=======
    Route::get('/layouts/app', [LayoutsController::class, 'app'])->name('layouts.app');
    Route::get('/layouts/cards', [LayoutsController::class, 'card'])->name('layouts.cards');

    // Soporte
    Route::get('/support', [SupportController::class, 'support'])->name('support');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');

    // Transacciones
    Route::get('/transactions/loans', [TransactionsController::class, 'loans'])->name('transactions.loans');
    Route::get('/transactions/transfer', [TransactionsController::class, 'transfer'])->name('transactions.transfer');
    Route::post('/transactions/transfer', [TransactionsController::class, 'store'])->name('transfers.store');

    Route::get('/transactions/qr-payments', [TransactionsController::class, 'qr'])->name('transactions.qr');
    Route::post('/transactions/qr-payments', [TransactionsController::class, 'generateQr'])->name('qr-payments.generate');

    // Perfil Usuario
    Route::get('/mi-perfil', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/mi-perfil', [UserController::class, 'updateProfile'])->name('users.update_profile');
    Route::put('/mi-perfil/password', [UserController::class, 'updatePassword'])->name('users.update_password');
    Route::delete('/mi-perfil', [UserController::class, 'destroyAccount'])->name('users.destroy_account');

    Route::get('/users/account', [UserController::class, 'account'])->name('users.account');

    // Administración de usuarios
    Route::resource('usuarios', UserController::class)->names('usuarios');
>>>>>>> Stashed changes
});

// Seguridad (pública si es una página informativa)
Route::get('/security', [AuthController::class, 'security'])->name('security');
<<<<<<< Updated upstream
=======
Route::post('/security/2fa', [AuthController::class, 'enableTwoFactor'])->name('security.2fa');
>>>>>>> Stashed changes
