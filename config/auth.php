<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Aquí defines el "guard" y el "broker" predeterminados para
    | autenticación y recuperación de contraseñas.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Definimos los distintos "guards" (métodos de autenticación).
    | En este caso solo usamos el guard "web" basado en sesiones.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Aquí definimos los "providers", que le dicen a Laravel cómo
    | obtener los usuarios desde tu base de datos.
    |
    | 🔹 IMPORTANTE:
    | Cambiamos el modelo predeterminado App\Models\User
    | por App\Models\Usuario, que es tu modelo real.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],

        // Alternativa si prefieres usar la base de datos directamente:
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'usuarios',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Configuración para el restablecimiento de contraseñas:
    | - Tabla donde se guardan los tokens
    | - Tiempo de expiración del token
    | - Tiempo de espera entre solicitudes (throttle)
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60, // minutos de validez del token
            'throttle' => 60, // segundos entre solicitudes de token
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Tiempo (en segundos) que dura una confirmación de contraseña antes
    | de volver a pedirla. Por defecto: 3 horas (10800 segundos).
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
