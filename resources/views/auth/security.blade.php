@extends('layouts.app')

@section('title', 'Seguridad - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">

        {{-- Header Mejorado: Back Button Estilizado --}}
        <header class="border-b border-gray-200 bg-white/90 backdrop-blur-sm shadow-sm sticky top-0 z-40 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2 text-gray-700 hover:text-blue-600 transition-colors
                          p-2 rounded-full hover:bg-gray-100 font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver al Dashboard
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Configuración de Seguridad</h1>
                <div class="w-6"></div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-4 sm:px-6 py-12 md:py-16 animate-fade-in-up" style="animation-delay: 0.1s;">

            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-10 text-center md:text-left">
                Seguridad de tu <span class="text-blue-600">Cuenta</span>
            </h2>

            {{-- Mensajes (Estilo Premium) --}}
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-400 text-green-700 rounded-xl font-semibold shadow-md flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 p-4 bg-red-50 border border-red-400 text-red-700 rounded-xl font-semibold shadow-md flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- CARD PRINCIPAL (Sombra Elevada) --}}
            <div class="bg-white border border-gray-100 rounded-3xl shadow-3xl shadow-blue-100/50 p-8 md:p-12 transition-shadow duration-300 hover:shadow-blue-200/60">

                @if(!$twoFactorEnabled)

                    <h3 class="text-3xl font-extrabold text-gray-900 mb-4 text-center md:text-left">Activar Autenticación de Dos Factores (2FA)</h3>
                    <p class="text-gray-500 mb-10 text-center md:text-left max-w-2xl mx-auto md:mx-0 text-lg">
                        Escanea el código QR con tu aplicación preferida (Google Authenticator, Authy, etc.).
                    </p>

                    {{-- Contenedor QR + Form --}}
                    <div class="flex flex-col lg:flex-row gap-10 md:gap-16 items-start justify-center">

                        {{-- QR y Clave --}}
                        <div class="flex flex-col items-center p-8 bg-gray-50 rounded-3xl border border-gray-200 shadow-inner w-full lg:max-w-xs transition-transform duration-300 hover:scale-[1.02]">
                            <p class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider">Paso 1: Escanear</p>

                            <img src="{{ $qrCode }}" class="w-48 h-48 mb-6 rounded-xl shadow-2xl border-4 border-white" alt="Código QR para 2FA" />

                            <p class="text-sm font-semibold text-gray-700 mb-2">Clave manual:</p>
                            <p class="text-base text-gray-700 font-mono bg-white p-3 rounded-xl border-2 border-dashed border-blue-300 select-all w-full text-center tracking-widest break-all shadow-md cursor-pointer transition-colors hover:bg-blue-50">
                                {{ $secret }}
                            </p>
                        </div>

                        {{-- Formulario --}}
                        <div class="w-full lg:max-w-md space-y-7">
                            <h4 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Paso 2: Verificar</h4>

                            <form method="POST" action="{{ route('security.2fa.enable') }}" class="space-y-6">
                                @csrf

                                {{-- Teléfono (Estilo Premium) --}}
                                <div>
                                    <label for="phone" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Número Telefónico (Opcional)</label>
                                    <input
                                        id="phone"
                                        type="tel"
                                        name="phone"
                                        class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 text-gray-900 rounded-xl
                                               outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 shadow-inner"
                                        placeholder="+52 123 456 7890"
                                        value="{{ old('phone') }}"
                                    />
                                </div>

                                {{-- Código 2FA (Estilo Premium) --}}
                                <div>
                                    <label for="code" class="block text-xs font-bold text-gray-700 uppercase tracking-widest mb-2">Código 2FA (6 dígitos)</label>
                                    <input
                                        id="code"
                                        type="text"
                                        inputmode="numeric"
                                        pattern="\d{6}"
                                        maxlength="6"
                                        name="code"
                                        required
                                        class="w-full h-14 text-center text-2xl font-bold tracking-[.4em] rounded-xl border border-gray-300 bg-gray-50
                                               focus:ring-2 focus:ring-blue-200 focus:border-blue-600 shadow-inner transition duration-300"
                                        placeholder="••••••"
                                    />
                                </div>

                                {{-- Botón: Fondo Degradado y Efecto de Hover más pronunciado --}}
                                <button type="submit"
                                        class="w-full h-14 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                                               hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                                               shadow-xl shadow-blue-500/40 mt-8
                                               transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-blue-300">
                                    Verificar y Activar 2FA
                                </button>

                            </form>
                        </div>
                    </div>

                @else
                    {{-- Vista 2FA ya activada (Estilo Premium) --}}
                    <div class="text-center py-8 md:py-12 space-y-6">
                        <svg class="w-16 h-16 text-green-600 mx-auto transform animate-pulse-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            <circle cx="12" cy="12" r="9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>

                        <h4 class="text-4xl font-extrabold text-gray-900">2FA Activado y Protegido ✅</h4>
                        <p class="text-lg text-gray-500 max-w-lg mx-auto">Tu cuenta cuenta con el nivel más alto de seguridad. Se solicitará el código de tu aplicación en cada inicio de sesión.</p>

                        <form method="POST" action="{{ route('security.2fa.disable') }}">
                            @csrf
                            {{-- Botón de Desactivar (Estilo de Riesgo/Advertencia) --}}
                            <button type="submit"
                                    class="mt-10 px-10 py-3 border-2 border-red-500 bg-white text-red-600 hover:bg-red-50
                                           rounded-xl transition font-extrabold shadow-lg hover:shadow-xl
                                           transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-red-300">
                                Desactivar Autenticación de Dos Factores
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </main>
    </div>

    {{-- CSS para Animación de Entrada --}}
    <style>
        @keyframes fadeInSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInSlideUp 0.6s ease-out forwards;
        }

        /* Animación para el checkmark activado */
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        .animate-pulse-slow {
            animation: pulse-slow 3s infinite ease-in-out;
        }
    </style>
@endsection
