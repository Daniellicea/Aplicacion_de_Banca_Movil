<?php

use Illuminate\Support\Facades\Route;

// Controladores
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Rutas de Invitado (Sin Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::redirect('/', '/login');

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Registro
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});


/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Con Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth.session')->group(function () {

    /*
    | Dashboard
    */
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'home'])->name('home');


    /*
    | Logout
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    /*
    | Seguridad / 2FA
    */
    Route::get('/security', [AuthController::class, 'security'])->name('security');

    // Activar 2FA
    Route::post('/security/2fa/enable', [AuthController::class, 'enableTwoFactor'])->name('security.2fa.enable');

    // Verificar código en configuración
    Route::post('/security/2fa/verify', [AuthController::class, 'verifyTwoFactor'])->name('security.2fa.verify');

    // Vista después del login para ingresar código 2FA
    Route::get('/2fa/verify', [AuthController::class, 'showTwoFactorPrompt'])->name('2fa.prompt');

    // Acción de desactivar 2FA
    Route::post('/security/2fa/disable', [AuthController::class, 'disableTwoFactor'])->name('security.2fa.disable');


    /*
    | Layouts demo
    */
    Route::get('/layouts/app', [LayoutsController::class, 'app'])->name('layouts.app');
    Route::get('/layouts/cards', [LayoutsController::class, 'cards'])->name('layouts.cards');


    /*
    | Soporte
    */
    Route::get('/support', [SupportController::class, 'support'])->name('support');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');


    /*
    | Transacciones
    */
    Route::prefix('transactions')->group(function () {
        Route::get('/loans', [TransactionsController::class, 'loans'])->name('transactions.loans');
        Route::get('/transfer', [TransactionsController::class, 'transfer'])->name('transactions.transfer');
        Route::post('/transfer', [TransactionsController::class, 'store'])->name('transfers.store');

        Route::get('/qr-payments', [TransactionsController::class, 'qr'])->name('transactions.qr');
        Route::post('/qr-payments', [TransactionsController::class, 'generateQr'])->name('qr-payments.generate');
    });


    /*
    | Perfil y Cuenta Usuario
    */
    Route::get('/mi-perfil', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/mi-perfil', [UserController::class, 'updateProfile'])->name('users.update_profile');
    Route::put('/mi-perfil/password', [UserController::class, 'updatePassword'])->name('users.update_password');
    Route::delete('/mi-perfil', [UserController::class, 'destroyAccount'])->name('users.destroy_account');

    Route::get('/users/account', [UserController::class, 'account'])->name('users.account');


    /*
    | CRUD admin de usuarios
    */
    Route::resource('usuarios', UserController::class)->names('usuarios');
});
