<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use OTPHP\TOTP;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

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

            // Si 2FA activo
            if ($usuario->two_factor_enabled) {
                session([
                    'usuario_id'     => $usuario->id,
                    'two_factor_pending' => true
                ]);

                return redirect()->route('2fa.prompt')->with('info', 'Ingresa tu código 2FA');
            }

            // Login normal
            session()->regenerate();
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
            'nombre'    => 'required|string|max:255',
            'correo'    => 'required|email|unique:usuarios,correo',
            'password'  => 'required|min:8|confirmed',
        ]);

        Usuario::create([
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'contrasena' => Hash::make($request->password),
        ]);

        return redirect()->route('login.form')->with('success', '✅ Registro exitoso, ahora inicia sesión.');
    }

    public function logout(Request $request)
    {
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Sesión cerrada correctamente.');
    }

    // ============================
    // SECURITY / 2FA PAGE
    // ============================
    public function security()
    {
        $user = Usuario::find(session('usuario_id'));

        if (!$user) return redirect()->route('login.form');

        $qrCode = null;
        $secret = null;

        if (!$user->two_factor_enabled) {

            $secret = session('temp_2fa_secret') ?? TOTP::create()->getSecret();
            session(['temp_2fa_secret' => $secret]);

            $totp = TOTP::create($secret);
            $totp->setLabel('Bankario-' . $user->correo);
            $totp->setIssuer('Bankario');

            $uri = $totp->getProvisioningUri();

            $renderer = new ImageRenderer(
                new RendererStyle(300),
                new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);
            $qrCodeSvg = $writer->writeString($uri);
            $qrCode = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
        }

        return view('auth.security', [
            'twoFactorEnabled' => $user->two_factor_enabled,
            'qrCode' => $qrCode,
            'secret' => $secret
        ]);
    }

    // ============================
    // ENABLE 2FA
    // ============================
    public function enableTwoFactor(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:20',
            'code' => 'required|numeric'
        ]);

        $user = Usuario::find(session('usuario_id'));
        $secret = session('temp_2fa_secret');

        if (!$secret) return back()->with('error', 'Error, refresca la página.');

        $totp = TOTP::create($secret);

        if (!$totp->verify($request->code)) {
            return back()->with('error', '❌ Código incorrecto.');
        }

        $user->two_factor_secret = $secret;
        $user->two_factor_phone = $request->phone;
        $user->two_factor_enabled = true;
        $user->save();

        session()->forget('temp_2fa_secret');

        return redirect()->route('security')->with('success', '✅ 2FA habilitado correctamente.');
    }

    // ============================
    // VERIFY CODE ON LOGIN
    // ============================
    public function verifyTwoFactor(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);
        $user = Usuario::find(session('usuario_id'));

        $totp = TOTP::create($user->two_factor_secret);

        if ($totp->verify($request->code)) {
            session([
                'two_factor_pending' => false,
                'usuario_nombre' => $user->nombre,
                'usuario_correo' => $user->correo
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', '❌ Código incorrecto.');
    }

    public function disableTwoFactor()
    {
        $user = Usuario::find(session('usuario_id'));

        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->two_factor_phone = null;
        $user->save();

        session()->forget('temp_2fa_secret');

        return back()->with('success', '2FA desactivado correctamente.');
    }

    public function showTwoFactorPrompt()
    {
        if (!session('two_factor_pending')) {
            return redirect()->route('dashboard');
        }

        return view('auth.2fa-verify');
    }
}
