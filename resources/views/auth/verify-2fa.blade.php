@extends('layouts.app')

@section('title', 'Seguridad - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">

        {{-- Header --}}
        <header class="border-b border-gray-200 bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm font-medium">Volver</span>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Seguridad</h1>
                <div class="w-6"></div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-6 py-16">

            {{-- Title --}}
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-12">
                Seguridad de tu <span class="text-blue-600">Cuenta</span>
            </h2>

            {{-- Mensajes --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-300 text-green-800 rounded-xl font-medium shadow-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-300 text-red-800 rounded-xl font-medium shadow-sm">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            {{-- CARD PRINCIPAL: Autenticación de Dos Factores --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8 md:p-10">

                @if(!$twoFactorEnabled)

                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Activar Autenticación de Dos Factores (2FA)</h3>
                    <p class="text-gray-500 mb-10">
                        Añade una capa extra de protección a tu cuenta. Escanea el código QR con una aplicación como Google Authenticator o Authy.
                    </p>

                    {{-- Contenido de Activación (QR y Formulario) --}}
                    <div class="flex flex-col md:flex-row gap-10 items-start">

                        {{-- QR y clave --}}
                        <div class="flex flex-col items-center p-4 bg-gray-50 rounded-xl border border-gray-200 shadow-inner w-full md:w-auto flex-shrink-0">
                            <img src="{{ $qrCode }}" class="w-40 h-40 mb-4 rounded-lg shadow-lg" alt="Código QR para 2FA" />
                            <p class="text-sm text-gray-700 font-mono bg-white p-2 rounded-lg border border-gray-300 select-all">
                                {{ $secret }}
                            </p>
                            <p class="text-xs text-gray-400 mt-2 text-center">Clave manual si no puedes escanear.</p>
                        </div>

                        {{-- Formulario de Verificación --}}
                        <div class="flex-1 space-y-6 w-full">
                            <form method="POST" action="{{ route('security.2fa.enable') }}" class="space-y-6">
                                @csrf

                                {{-- Teléfono --}}
                                <div class="space-y-2">
                                    <label for="phone" class="block text-sm font-semibold text-gray-700">Número Telefónico</label>
                                    <input
                                        id="phone"
                                        type="tel"
                                        name="phone"
                                        required
                                        class="w-full h-12 px-4 rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50"
                                        placeholder="+52 123 456 7890"
                                    />
                                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Código 2FA --}}
                                <div class="space-y-2">
                                    <label for="code" class="block text-sm font-semibold text-gray-700">Código 2FA (6 dígitos)</label>
                                    <input
                                        id="code"
                                        type="text"
                                        maxlength="6"
                                        name="code"
                                        required
                                        class="w-full h-12 px-4 rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-gray-50 text-center tracking-widest text-xl font-bold"
                                        placeholder="••••••"
                                    />
                                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Botón Activar --}}
                                <button class="w-full h-14 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-300/50 transform hover:scale-[1.01] transition duration-300">
                                    Activar 2FA y Guardar Teléfono
                                </button>
                            </form>
                        </div>

                    </div>

                @else

                    {{-- Ya activado --}}
                    <div class="text-center py-6 space-y-5">
                        <div class="flex justify-center mb-4">
                            <!-- Icono de escudo grande y verde -->
                            <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.617-4.21a2 2 0 011.666 2.453l-1.04 4.159a4 4 0 01-3.2 2.802l-4.113 1.372a4 4 0 01-4.887-.905L4.555 13.91a2 2 0 01-.223-2.61L8.383 6.79a2 2 0 012.453-1.666l4.159 1.04a4 4 0 012.802 3.2l1.372 4.113a4 4 0 01-.905 4.887L17.09 19.445a2 2 0 01-2.61.223L8.79 16.383a2 2 0 01-1.666-2.453L8.163 9.77a4 4 0 013.2-2.802l4.113-1.372a4 4 0 014.887.905z"/>
                            </svg>
                        </div>
                        <h4 class="text-4xl font-extrabold text-gray-900">2FA Activo</h4>
                        <p class="text-lg text-gray-500">Tu cuenta está altamente protegida. Ahora se solicitará un código adicional en cada inicio de sesión.</p>

                        <form method="POST" action="{{ route('security.2fa.disable') }}">
                            @csrf
                            <button class="mt-6 px-6 py-2 border border-red-400 bg-red-50 text-red-600 hover:bg-red-100 hover:border-red-500 font-semibold rounded-xl transition duration-300 shadow-sm">
                                Desactivar Autenticación de Dos Factores
                            </button>
                        </form>
                    </div>

                @endif
            </div>
        </main>
    </div>
@endsection
