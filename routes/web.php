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
| RUTA PRINCIPAL – SIEMPRE IR A LOGIN Y CERRAR SESIÓN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    auth()->logout();       // Cierra sesión si existía
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| LOGIN – SIEMPRE MOSTRAR LOGIN Y CERRAR SESIÓN
|--------------------------------------------------------------------------
*/

// Importante: NO usar session()->flush() porque rompe CSRF.
Route::get('/login', function () {
    auth()->logout();  // Cierra sesión, pero deja CSRF activo
    return app(AuthController::class)->showLogin();
})->name('login.form');

// Procesar el login (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login');


/*
|--------------------------------------------------------------------------
| REGISTRO – SOLO INVITADOS
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS – SOLO USUARIOS AUTENTICADOS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    | Dashboard
    */
    Route::get('/dashboard', [HomeController::class, 'home'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'home'])->name('home');

    /*
    | Logout manual
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    | Seguridad / 2FA
    */
    Route::get('/security', [AuthController::class, 'security'])->name('security');
    Route::post('/security/2fa/enable', [AuthController::class, 'enableTwoFactor'])->name('security.2fa.enable');
    Route::post('/security/2fa/verify', [AuthController::class, 'verifyTwoFactor'])->name('security.2fa.verify');
    Route::get('/2fa/verify', [AuthController::class, 'showTwoFactorPrompt'])->name('2fa.prompt');
    Route::post('/security/2fa/disable', [AuthController::class, 'disableTwoFactor'])->name('security.2fa.disable');

    /*
    | Layouts de prueba
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
    | Perfil y Cuenta usuario
    */
    Route::get('/mi-perfil', [UserController::class, 'profile'])->name('users.profile');
    Route::put('/mi-perfil', [UserController::class, 'updateProfile'])->name('users.update_profile');
    Route::put('/mi-perfil/password', [UserController::class, 'updatePassword'])->name('users.update_password');
    Route::delete('/mi-perfil', [UserController::class, 'destroyAccount'])->name('users.destroy_account');

    Route::get('/users/account', [UserController::class, 'account'])->name('users.account');

    /*
    | CRUD Admin de usuarios
    */
    Route::resource('usuarios', UserController::class)->names('usuarios');
});


/*
|--------------------------------------------------------------------------
| Recuperación de contraseña
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::post('/mi-perfil/avatar', [UserController::class, 'uploadAvatar'])->name('users.upload_avatar');
Route::delete('/mi-perfil/avatar', [UserController::class, 'deleteAvatar'])->name('users.delete_avatar');
