@extends('layouts.app')

@section('title', 'Registro - Bankario')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-background">
        <div class="w-full max-w-md bg-card border border-border rounded-xl p-8 shadow-lg">
            <h1 class="text-3xl font-bold text-center text-foreground mb-6">Crear cuenta</h1>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg">
                    <ul class="text-sm">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORMULARIO DE REGISTRO --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-foreground mb-1">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-border rounded-lg p-2 bg-background text-foreground">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-foreground mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-border rounded-lg p-2 bg-background text-foreground">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-foreground mb-1">Confirmar correo</label>
                    <input type="email" name="email_confirmation" value="{{ old('email_confirmation') }}" required
                           class="w-full border border-border rounded-lg p-2 bg-background text-foreground">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-foreground mb-1">Contraseña</label>
                    <input type="password" name="password" required
                           class="w-full border border-border rounded-lg p-2 bg-background text-foreground">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-foreground mb-1">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full border border-border rounded-lg p-2 bg-background text-foreground">
                </div>

                <button type="submit"
                        class="w-full bg-foreground text-background font-semibold py-2 rounded-lg hover:opacity-90 transition">
                    Registrarme
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-muted-foreground">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login.form') }}" class="font-semibold text-foreground hover:underline">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
