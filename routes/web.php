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

/*
|--------------------------------------------------------------------------
| RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
| Estas rutas permiten el acceso al login y registro sin necesidad de estar autenticado.
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Registro
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

/*
|--------------------------------------------------------------------------
| RUTAS ACCESIBLES TRAS INICIAR SESIÓN (sin usar middleware 'auth')
|--------------------------------------------------------------------------
| Como usas tu propia sesión manual con 'usuario_id', estas rutas no deben
| estar protegidas por el middleware 'auth' de Laravel.
*/
Route::get('/dashboard', [home::class, 'home'])->name('dashboard');
Route::get('/home', [home::class, 'home'])->name('home');

// Cerrar sesión (puedes usar GET mientras estás en desarrollo)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| SECCIONES DE LA APLICACIÓN
|--------------------------------------------------------------------------
*/

// Layouts
Route::get('/layouts/app', [layouts::class, 'app'])->name('app');
Route::get('/layouts/cards', [layouts::class, 'card'])->name('layouts.cards');

// Soporte
Route::get('/support', [support::class, 'support'])->name('support');

// Transacciones
Route::get('/transactions/loans', [transactions::class, 'loans'])->name('transactions.loans');
Route::get('/transactions/transfer', [transactions::class, 'transfer'])->name('transactions.transfer');
Route::post('/transactions/transfer', [transactions::class, 'store'])->name('transactions.transfer.store');

// Pagos QR (rutas corregidas con los nombres correctos usados en el dashboard)
Route::get('/transactions/qr-payments', [transactions::class, 'qr'])->name('transactions.qr');
Route::post('/transactions/qr-payments', [transactions::class, 'generateQr'])->name('transactions.qr.generate');

// Cuentas / Usuarios
Route::get('/users/account', [user::class, 'account'])->name('users.account');
Route::get('/accounts', [user::class, 'account'])->name('accounts');

// Seguridad (página informativa pública)
Route::get('/security', [AuthController::class, 'security'])->name('security');
