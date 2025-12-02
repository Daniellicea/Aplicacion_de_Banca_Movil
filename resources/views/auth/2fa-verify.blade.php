@extends('layouts.app')

@section('title', 'Verificar Código 2FA - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-6 py-16">
        <div class="w-full max-w-md">

            {{-- Logo y título (para consistencia) --}}
            <div class="text-center mb-10 animate-fade-in-down" style="animation-delay: 0.1s;">
                <h1 class="text-5xl font-extrabold text-blue-700 mb-1 tracking-tighter drop-shadow-md">2FA</h1>
                <p class="text-lg text-gray-500 uppercase tracking-widest font-bold">Verificación de Seguridad</p>
            </div>

            {{-- Tarjeta principal: Diseño Elevado y Suave --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-10 shadow-3xl shadow-blue-200/50
                        transform transition duration-500 hover:shadow-blue-300/60 animate-fade-in-down" style="animation-delay: 0.3s;">

                <div class="text-center mb-8">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900">
                        Autenticación Requerida
                    </h2>
                    <p class="text-gray-500 mt-2 text-base">
                        Ingresa el código de 6 dígitos de tu aplicación autenticadora
                    </p>
                </div>

                {{-- Mensajes (Estilo más vivo) --}}
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-400 text-red-700 rounded-xl font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-400 text-blue-700 rounded-xl font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ session('info') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('security.2fa.verify') }}" class="space-y-8">
                    @csrf

                    <div class="space-y-2">
                        <label for="code" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">
                            Código 2FA
                        </label>

                        <input type="text"
                               id="code"
                               name="code"
                               maxlength="6"
                               required
                               autofocus
                               class="w-full h-16 text-center text-3xl font-bold tracking-[.4em] rounded-xl border border-gray-300 bg-gray-50
                                      focus:ring-2 focus:ring-blue-200 focus:border-blue-600 shadow-inner transition duration-300"
                               placeholder="••••••">
                    </div>

                    {{-- Botón: Fondo Degradado y Efecto de Hover más pronunciado --}}
                    <button
                        type="submit"
                        class="w-full h-14 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                               hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                               shadow-xl shadow-blue-500/40
                               transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-300"
                    >
                        Verificar Código
                    </button>
                </form>
            </div>

            {{-- Enlace de Cierre de Sesión --}}
            <div class="text-center mt-8 animate-fade-in-down" style="animation-delay: 0.5s;">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-sm text-gray-500 hover:text-red-600 font-medium underline transition-colors">
                    Cancelar y cerrar sesión
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
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
