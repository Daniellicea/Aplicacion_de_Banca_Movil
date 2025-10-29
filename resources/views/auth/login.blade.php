@extends('layouts.app')

@section('title', 'Iniciar Sesión - Bankario')

@section('content')
    <div class="min-h-screen bg-background flex items-center justify-center px-6">
        <div class="w-full max-w-md">
            <!-- Logo y título -->
            <div class="text-center mb-12">
                <h1 class="text-7xl font-bold text-foreground mb-4">Bankario</h1>
                <p class="text-lg text-muted-foreground uppercase tracking-wider">Banca Móvil</p>
            </div>

            <!-- Formulario de login -->
            <div class="bg-card border-2 border-border rounded-lg p-8">
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-2 border-red-200 rounded-lg">
                        <p class="text-red-800 text-sm font-semibold">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-3">
                        <label for="email" class="block text-sm font-medium text-foreground uppercase tracking-wide">
                            Correo Electrónico
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            placeholder="tu@email.com"
                            value="{{ old('email') }}"
                            class="w-full h-14 px-4 text-base bg-background border-2 border-border focus:border-foreground transition-colors rounded-lg outline-none"
                            required
                            autofocus
                        />
                    </div>

                    <div class="space-y-3">
                        <label for="password" class="block text-sm font-medium text-foreground uppercase tracking-wide">
                            Contraseña
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            class="w-full h-14 px-4 text-base bg-background border-2 border-border focus:border-foreground transition-colors rounded-lg outline-none"
                            required
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full h-14 text-base font-semibold bg-primary hover:bg-primary/90 text-primary-foreground transition-all rounded-lg"
                    >
                        Iniciar Sesión
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="#" class="text-sm text-muted-foreground hover:text-foreground transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="mt-8 text-center">
                <p class="text-sm text-muted-foreground">
                    ¿No tienes cuenta?
                    <a href="{{ route('register.form') }}" class="text-foreground font-semibold hover:underline">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
