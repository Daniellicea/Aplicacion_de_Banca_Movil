@extends('layouts.app')

@section('title', 'Iniciar Sesión - Bankario')

@section('content')
    {{-- Contenedor principal con fondo suave --}}
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 md:px-6">
        <div class="w-full max-w-md">

            {{-- Logo y título --}}
            <div class="text-center mb-12 animate-fade-in-down" style="animation-delay: 0.1s;">
                <h1 class="text-7xl font-extrabold text-blue-700 mb-2 tracking-tighter drop-shadow-md">Bankario</h1>
                <p class="text-lg text-gray-500 uppercase tracking-widest font-bold">Banca Móvil</p>
            </div>

            {{-- Tarjeta principal: Diseño Elevado y Suave --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-10 shadow-3xl shadow-blue-200/50
                        transform transition duration-500 hover:shadow-blue-300/60 animate-fade-in-down" style="animation-delay: 0.3s;">

                {{-- Mensaje de éxito (Estilo más vivo) --}}
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-400 rounded-xl shadow-md">
                        <p class="text-green-700 text-sm font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                {{-- Mensaje de error (Estilo más vivo) --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-400 rounded-xl shadow-md">
                        <p class="text-red-700 text-sm font-semibold flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $errors->first() }}
                        </p>
                    </div>
                @endif

                {{-- Formulario de inicio de sesión --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Campo correo --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">
                            Correo Electrónico
                        </label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            placeholder="tu@email.com"
                            value="{{ old('email') }}"
                            class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 text-gray-900 rounded-xl
                                   outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 shadow-inner"
                            required
                            autofocus
                        />
                    </div>

                    {{-- Campo contraseña --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">
                            Contraseña
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 text-gray-900 rounded-xl
                                   outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 shadow-inner"
                            required
                        />
                    </div>

                    {{-- Botón: Fondo Degradado y Efecto de Hover más pronunciado --}}
                    <button
                        type="submit"
                        class="w-full h-12 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                               hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                               shadow-xl shadow-blue-500/40 mt-8
                               transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-300"
                    >
                        Iniciar Sesión
                    </button>
                </form>

                {{-- Link de recuperar contraseña --}}
                <div class="mt-6 text-center">
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </div>

            {{-- Enlace a registro --}}
            <div class="mt-8 text-center animate-fade-in-down" style="animation-delay: 0.5s;">
                <p class="text-sm text-gray-500">
                    ¿No tienes cuenta?
                    <a href="{{ route('register.form') }}" class="text-blue-600 font-extrabold hover:underline transition-colors">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>

    {{-- CSS para Animación de Entrada --}}
    <style>
        /* Define la animación para que los elementos caigan ligeramente y aparezcan */
        @keyframes fadeInSlideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Clase Tailwind customizada */
        .animate-fade-in-down {
            opacity: 0; /* Asegura que el elemento esté oculto al inicio */
            animation: fadeInSlideDown 0.6s ease-out forwards;
        }
    </style>
@endsection
