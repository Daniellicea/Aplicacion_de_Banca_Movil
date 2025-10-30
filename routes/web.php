<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Home;
use App\Http\Controllers\Layouts;
use App\Http\Controllers\Support;
use App\Http\Controllers\Transactions;
use App\Http\Controllers\UserController; // ✅ ESTE ES EL CONTROLADOR CORRECTO

/*
|--------------------------------------------------------------------------
| RUTA DE BIENVENIDA
|--------------------------------------------------------------------------
*/
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
| RUTAS DESPUÉS DE INICIAR SESIÓN
|--------------------------------------------------------------------------
| Estas rutas se acceden luego del login, pero sin middleware auth (porque usas sesión manual).
*/
Route::get('/dashboard', [Home::class, 'home'])->name('dashboard');
Route::get('/home', [Home::class, 'home'])->name('home');

// Cerrar sesión
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| SECCIONES DE LA APLICACIÓN
|--------------------------------------------------------------------------
*/

// Layouts
Route::get('/layouts/app', [Layouts::class, 'app'])->name('app');
Route::get('/layouts/cards', [Layouts::class, 'card'])->name('layouts.cards');

// Soporte
Route::get('/support', [Support::class, 'support'])->name('support');

// Transacciones
Route::get('/transactions/loans', [Transactions::class, 'loans'])->name('transactions.loans');
Route::get('/transactions/transfer', [Transactions::class, 'transfer'])->name('transactions.transfer');
Route::post('/transactions/transfer', [Transactions::class, 'store'])->name('transactions.transfer.store');

// Pagos QR
Route::get('/transactions/qr-payments', [Transactions::class, 'qr'])->name('transactions.qr');
Route::post('/transactions/qr-payments', [Transactions::class, 'generateQr'])->name('transactions.qr.generate');

// Cuentas y perfil de usuario
Route::get('/users/account', [UserController::class, 'account'])->name('users.account');
Route::get('/accounts', [UserController::class, 'account'])->name('accounts');

// Seguridad (pública)
Route::get('/security', [AuthController::class, 'security'])->name('security');

/*
|--------------------------------------------------------------------------
| CRUD DE USUARIOS
|--------------------------------------------------------------------------
*/
Route::resource('usuarios', UserController::class)->names('usuarios');
