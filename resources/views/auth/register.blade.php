@extends('layouts.app')

@section('title', 'Registro - Bankario')

@section('content')
    {{-- Contenedor principal con fondo suave --}}
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
        <div class="w-full max-w-lg">

            {{-- Logo y título (para consistencia) --}}
            <div class="text-center mb-10 animate-fade-in-down" style="animation-delay: 0.1s;">
                <h1 class="text-7xl font-extrabold text-blue-700 mb-2 tracking-tighter drop-shadow-md">Bankario</h1>
                <p class="text-lg text-gray-500 uppercase tracking-widest font-bold">Crea tu cuenta</p>
            </div>

            {{-- Tarjeta principal: Diseño Elevado y Suave --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-10 shadow-3xl shadow-blue-200/50
                        transform transition duration-500 hover:shadow-blue-300/60 animate-fade-in-down" style="animation-delay: 0.3s;">

                <h2 class="text-3xl font-extrabold text-center text-gray-900 mb-8 tracking-tight flex items-center justify-center gap-2">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Regístrate
                </h2>

                {{-- Mensaje de error (Estilo más vivo) --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-400 text-red-700 p-4 rounded-xl shadow-md">
                        <p class="font-bold text-sm mb-1 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Error en el registro:
                        </p>
                        <ul class="text-sm list-disc list-inside mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORMULARIO DE REGISTRO --}}
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    {{-- Nombre completo --}}
                    <div>
                        <label for="nombre" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Nombre completo</label>
                        <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" required
                               placeholder="Ej. Juan Pérez"
                               class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 text-gray-900 rounded-xl
                                   outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 shadow-inner">
                    </div>

                    {{-- Correo electrónico --}}
                    <div>
                        <label for="correo" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Correo electrónico</label>
                        <input id="correo" type="email" name="correo" value="{{ old('correo') }}" required
                               placeholder="tu.correo@ejemplo.com"
                               class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 text-gray-900 rounded-xl
                                   outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 shadow-inner">
                    </div>

                    {{-- Contraseña --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Contraseña</label>
                            <input id="password" type="password" name="password" required
                                   placeholder="Mínimo 8 caracteres"
                                   class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 text-gray-900 rounded-xl
                                       outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 shadow-inner">
                        </div>

                        {{-- Confirmar contraseña --}}
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Confirmar</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   placeholder="Confirma tu contraseña"
                                   class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 text-gray-900 rounded-xl
                                       outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 shadow-inner">
                        </div>
                    </div>

                    {{-- Botón: Fondo Degradado y Efecto de Hover más pronunciado --}}
                    <button type="submit"
                            class="w-full h-12 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                                   hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                                   shadow-xl shadow-blue-500/40 mt-8
                                   transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-300">
                        Registrarme
                    </button>
                </form>

                {{-- Enlace a login --}}
                <div class="mt-8 text-center border-t border-gray-100 pt-6">
                    <p class="text-sm text-gray-500">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login.form') }}" class="font-extrabold text-blue-600 hover:text-blue-700 hover:underline transition duration-150">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
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
