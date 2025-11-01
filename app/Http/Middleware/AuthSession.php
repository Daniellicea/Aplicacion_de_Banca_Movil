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
