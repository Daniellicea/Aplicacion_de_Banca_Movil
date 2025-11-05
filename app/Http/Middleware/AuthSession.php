<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('usuario_id')) {
            return redirect()->route('login.form')
                ->withErrors('Debes iniciar sesión.');
        }

        return $next($request);
    }
}
class Verify2FA
{
    public function handle($request, Closure $next)
    {
        if (session('two_factor_enabled') && !session('2fa_verified')) {
            return redirect()->route('2fa.prompt');
        }

        return $next($request);
    }
}
