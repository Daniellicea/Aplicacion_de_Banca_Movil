<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('correo', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {
            $request->session()->regenerate();

            session([
                'usuario_id'     => $usuario->id,
                'usuario_nombre' => $usuario->nombre,
                'usuario_correo' => $usuario->correo,
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.',
        ])->withInput(['email' => $request->email]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'correo'   => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:8|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'contrasena' => Hash::make($request->password),
        ]);

        $request->session()->regenerate();

        session([
            'usuario_id'     => $usuario->id,
            'usuario_nombre' => $usuario->nombre,
            'usuario_correo' => $usuario->correo,
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión para continuar.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->forget(['usuario_id', 'usuario_nombre', 'usuario_correo']);

        return redirect()->route('login.form');
    }

    public function security()
    {
        $id = session('usuario_id');
        $usuario = $id ? Usuario::find($id) : null;

        // Si el usuario tiene teléfono guardado → Asumimos 2FA activo
        $twoFactorEnabled = $usuario && $usuario->phone ? true : false;

        return view('auth.security', compact('usuario', 'twoFactorEnabled'));
    }
}
