@extends('layouts.app')

@section('title', 'Dashboard - Bankario')

@section('content')
    {{-- Alpine.js State para el saldo y privacidad. Inicializa showBalance: true --}}
    <div x-data="{ showBalance: true }" class="min-h-screen bg-gray-50 text-gray-900 font-sans">

        {{-- Header: Sticky y Sutil --}}
        <header class="sticky top-0 z-40 border-b border-gray-200 bg-white/90 backdrop-blur-sm shadow-sm transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <h1 class="text-3xl font-extrabold text-blue-700 tracking-wider hover:text-blue-500 transition-colors duration-300">BANKARIO</h1>

                <div class="flex items-center gap-8">
                    <button class="relative p-2 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 
                        6.002 0 00-4-5.659V5a2 
                        2 0 10-4 0v.341C7.67 
                        6.165 6 8.388 6 
                        11v3.159c0 .538-.214 
                        1.055-.595 1.436L4 
                        17h5m6 0v1a3 
                        3 0 11-6 0v-1m6 0H9"/>
        </svg>
    {{-- Punto de notificación --}}
    <span class="absolute top-1 right-1 block w-2.5 h-2.5 bg-red-500 rounded-full"></span>
</button>
                    {{-- Menú desplegable "Mi Perfil" (Cambiado a Click para mejor UX) --}}
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">

                        <button @click="open = !open" type="button"
                                class="flex items-center p-2 rounded-full bg-blue-50 hover:bg-blue-100 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">

                            {{-- Avatar --}}
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 text-white font-extrabold text-sm shadow-md">
                                {{ substr(session('usuario_nombre') ?? 'U', 0, 1) }}
                            </div>

                            {{-- Nombre --}}
                            <span class="ml-2 mr-1 text-sm font-bold text-gray-700 hidden sm:inline">{{ session('usuario_nombre') ?? 'Usuario' }}</span>

                            {{-- Icono --}}
                            <svg class="w-4 h-4 ml-1 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180 text-blue-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-64 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 z-50 origin-top-right">

                            <div class="p-4 border-b border-gray-100">
                                <p class="text-lg font-extrabold text-gray-900">{{ session('usuario_nombre') ?? 'Usuario' }}</p>
                                <p class="text-xs text-gray-500 font-medium mt-1">Sesión iniciada</p>
                            </div>

                            <div class="py-2">
                                <a href="{{ route('usuarios.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Mi Perfil
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-2 pt-2">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-3 w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-150">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-3m0-4V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-16">

            {{-- SECCIÓN 1: BIENVENIDA (Tipografía mejorada) --}}
            <div class="mb-14 animate-fade-in-up" style="animation-delay: 0.1s;">
                <h2 class="text-6xl sm:text-7xl font-extrabold text-gray-900 mb-3 leading-tight">
                    Hola, <span class="text-blue-600 relative after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:bg-blue-300 after:rounded-full after:animate-pulse">
                        {{ session('usuario_nombre') ?? 'Usuario' }}
                    </span>
                </h2>
                {{-- Aumento de tamaño para complementar el título --}}
                <p class="text-xl sm:text-2xl text-gray-600 font-medium mt-4">Consulta tus finanzas y realiza tus operaciones al instante.</p>
            </div>

            {{-- SECCIÓN 2: SALDO Y MONEDAS --}}
            <div class="grid lg:grid-cols-3 gap-8 mb-20 animate-fade-in-up" style="animation-delay: 0.3s;">

                {{-- Tarjeta de saldo (Efecto Premium y Botón de Privacidad) --}}
                <div class="lg:col-span-2 bg-gradient-to-br from-blue-600 to-cyan-700 rounded-3xl p-10 text-white shadow-2xl shadow-blue-300/80
                            transform hover:scale-[1.01] transition-all duration-500 relative overflow-hidden group">

                    {{-- Overlay de brillo sutil para efecto premium --}}
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-10 transition-opacity duration-500"
                         style="background: radial-gradient(circle at 100% 0, rgba(255,255,255,0.4), transparent 50%);">
                    </div>

                    <p class="text-sm uppercase tracking-widest opacity-90 mb-4 font-bold">Saldo Total Actual</p>

                    @php
                        // Lógica de saldo
                        $transactions = session('transactions', []);
                        $saldo_real = session('saldo_real', 5000);
                        $gastos = 0;
                        foreach($transactions as $t) {
                            if(($t['type'] ?? '') === 'debit') $gastos += abs($t['amount'] ?? 0);
                        }
                        // $saldo_actual = $saldo_real - $gastos;
                        $saldo_actual = $saldo_real;

                        $saldo_formateado = number_format($saldo_actual, 2);

                        // Formato del saldo oculto (ej. $5,000.00 -> $***.00)
                        $saldo_oculto = '***';
                        if (strpos($saldo_formateado, '.') !== false) {
                            $saldo_oculto .= '.' . substr($saldo_formateado, strpos($saldo_formateado, '.') + 1);
                        }
                    @endphp

                    <div class="flex items-center justify-between mb-10">
                        {{-- Saldo Dinámico CORREGIDO (solo se renderiza una vez) --}}
                        <p class="text-6xl sm:text-7xl lg:text-8xl font-extrabold tracking-tighter transition-all duration-500 group-hover:tracking-normal">
                            <span x-show="showBalance">
                                ${{ $saldo_formateado }}
                            </span>
                            <span x-cloak x-show="!showBalance" class="tracking-widest">
                                ${{ $saldo_oculto }}
                            </span>
                        </p>

                        {{-- Botón de Privacidad (Ocultar Saldo) --}}
                        <button @click="showBalance = !showBalance"
                                class="p-3 text-blue-200 hover:text-white transition-colors duration-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300">
                            <svg x-show="showBalance" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="!showBalance" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.258 0 2.441.385 3.491 1.05M12 16a4 4 0 00-4-4m4 4a4 4 0 004-4m0 0a4 4 0 00-4-4m4 4l.01 0M21 21L3 3" /></svg>
                        </button>
                    </div>

                    <div class="flex gap-12 border-t border-white/40 pt-6">
                        <div class="flex-1 transition-transform duration-300 group-hover:translate-x-1">
                            <p class="text-xs uppercase tracking-wider opacity-70 mb-1 font-semibold">Ingresos (último periodo)</p>
                            <p class="text-2xl font-bold text-green-200 transition-colors duration-300 hover:text-green-300">+${{ number_format($saldo_real, 2) }}</p>
                        </div>
                        <div class="flex-1 transition-transform duration-300 group-hover:-translate-x-1">
                            <p class="text-xs uppercase tracking-wider opacity-70 mb-1 font-semibold">Gastos (último periodo)</p>
                            <p class="text-2xl font-bold text-red-300 transition-colors duration-300 hover:text-red-400">-${{ number_format($gastos, 2) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tabla de Monedas Dinámicas (Mejor contraste) --}}
                <div class="lg:col-span-1 p-6 bg-white rounded-3xl shadow-xl border border-gray-100">
                    <h4 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Mercado de Monedas</h4>

                    @php
                        $currencies = [
                            ['name' => 'EUR/USD', 'price' => 1.0835, 'change' => 0.0021, 'status' => 'up'],
                            ['name' => 'USD/JPY', 'price' => 157.45, 'change' => -0.55, 'status' => 'down'],
                            ['name' => 'BTC/USD', 'price' => 67450.00, 'change' => 1250.70, 'status' => 'up'],
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($currencies as $currency)
                            @php
                                $isUp = $currency['status'] === 'up';
                                $colorClass = $isUp ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100';
                                $icon = $isUp ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>' :
                                                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>';
                                $changeFormatted = number_format(abs($currency['change']), 4);
                                $priceFormatted = number_format($currency['price'], 2);
                            @endphp

                            {{-- Contenedor con hover más visible --}}
                            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:bg-blue-50/50 transition-all duration-300 cursor-pointer">
                                <div>
                                    <p class="text-base font-bold text-gray-800">{{ $currency['name'] }}</p>
                                    <p class="text-sm text-gray-500 font-medium"> ${{ $priceFormatted }}</p>
                                </div>
                                {{-- Cambio con mejor contraste --}}
                                <div class="flex items-center gap-2 p-1 px-3 rounded-full font-extrabold text-xs {{ $colorClass }} transition-transform duration-500 hover:scale-105">
                                    {!! $icon !!}
                                    <span>{{ $changeFormatted }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- SECCIÓN 3: SERVICIOS (Con Iconografía y manejo de rutas) --}}
            <div class="animate-fade-in-up" style="animation-delay: 0.5s;">
                <h3 class="text-4xl font-extrabold text-gray-800 mb-10">Acceso Rápido</h3>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                    @php
                        // Definición de servicios con icono y clases estáticas
                        $services = [
                            ['route' => 'users.account', 'title' => 'Cuentas y Movimientos', 'description' => 'Consulta tus saldos y transacciones.', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>', 'color' => 'border-blue-500 hover:border-blue-700 group-hover:text-blue-600'],
                            ['route' => 'transactions.transfer', 'title' => 'Transferencias', 'description' => 'Envía dinero fácilmente.', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" /></svg>', 'color' => 'border-green-500 hover:border-green-700 group-hover:text-green-600'],
                            ['route' => 'transactions.qr', 'title' => 'Pagos QR', 'description' => 'Escanea o genera códigos QR.', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11h-2v2h2v-2zM11 11H9v2h2v-2zM15 7h-2v2h2V7zM11 7H9v2h2V7zM15 15h-2v2h2v-2zM11 15H9v2h2v-2zM7 7H5v2h2V7zM7 11H5v2h2v-2zM7 15H5v2h2v-2zM17 7h-2v2h2V7zM17 11h-2v2h2v-2zM17 15h-2v2h2v-2z" /></svg>', 'color' => 'border-purple-500 hover:border-purple-700 group-hover:text-purple-600'],
                            ['route' => 'support', 'title' => 'Soporte', 'description' => 'Ayuda personalizada 24/7.', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m-7.071 7.07l3.536 3.536m7.071-7.071L12 12m-2.121 2.121L5.636 18.364m12.728-12.728l-5.657 5.657m-3.535 3.535L5.636 5.636m12.728 0a.5.5 0 11-1 0 .5.5 0 011 0zM12 18.5a.5.5 0 100-1 .5.5 0 000 1zM5.636 12a.5.5 0 110-1 .5.5 0 010 1zM18.364 12a.5.5 0 110-1 .5.5 0 010 1zM12 5.5a.5.5 0 110-1 .5.5 0 000 1z" /></svg>', 'color' => 'border-yellow-500 hover:border-yellow-700 group-hover:text-yellow-600'],
                            ['route' => 'security', 'title' => 'Seguridad', 'description' => 'Activa 2FA y protege tu cuenta.', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a3 3 0 003-3v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5a3 3 0 003 3zM7 9V7a5 5 0 0110 0v2M5 9h14" /></svg>', 'color' => 'border-red-500 hover:border-red-700 group-hover:text-red-600'],
                            ['route' => 'investments', 'title' => 'Inversiones', 'description' => 'Comienza a invertir y crece.', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3 3 7-7m-4-7a2 2 0 11-4 0 2 2 0 014 0zM17 12a2 2 0 100-4 2 2 0 000 4z" /></svg>', 'color' => 'border-indigo-500 hover:border-indigo-700 group-hover:text-indigo-600'],
                        ];
                    @endphp

                    @foreach($services as $service)
                        @php
                            $targetRoute = '#';
                            $routeExists = isset($service['route']) && Route::has($service['route']);
                            if ($routeExists) {
                                $targetRoute = route($service['route']);
                            }
                            // Usamos las clases completas definidas en el array
                            $borderClasses = $service['color'];
                            $linkClass = $routeExists ? '' : 'opacity-60 cursor-not-allowed pointer-events-none';
                            $colorName = explode('-', $service['color'])[1]; // Obtiene 'blue', 'green', etc.
                        @endphp

                        <a href="{{ $targetRoute }}"
                           class="block w-full p-8 bg-white border border-gray-100 rounded-2xl shadow-lg
                                  transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300 group
                                  border-l-4 {{ $borderClasses }} {{ $linkClass }}">

                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-xl font-extrabold text-gray-900 mb-2 group-hover:text-{{ $colorName }}-600 transition-colors duration-300">
                                        {{ $service['title'] }}
                                    </h4>
                                    <p class="text-sm text-gray-500 font-medium">{{ $service['description'] }}</p>
                                </div>

                                {{-- Ícono del servicio con fondo y hover dinámico --}}
                                <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-50 text-gray-400 group-hover:bg-{{ $colorName }}-50 group-hover:text-{{ $colorName }}-600 transition-all duration-300 group-hover:scale-110 shadow-inner">
                                    {!! $service['icon'] !!}
                                </div>
                            </div>

                            @unless($routeExists)
                                <div class="mt-4 text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full inline-block">
                                    Próximamente
                                </div>
                            @endunless
                        </a>
                    @endforeach

                </div>
            </div>
        </main>
    </div>

    {{-- Estilos para las animaciones y asegurar la compilación de Tailwind --}}
    <style>
        /* Definición de la animación de entrada */
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

        /* Clase Tailwind customizada para la animación */
        .animate-fade-in-up {
            opacity: 0; /* Asegura que el elemento esté oculto al inicio */
            animation: fadeInSlideUp 0.6s ease-out forwards;
        }

        /* Ocultar elementos Alpine */
        [x-cloak] {
            display: none !important;
        }

        /* Incluir un placeholder para las clases dinámicas de color (aunque ya se usan estáticamente en el array, es buena práctica si se añaden más) */
        .border-blue-500, .hover\:border-blue-700:hover, .group-hover\:text-blue-600:hover,
        .border-green-500, .hover\:border-green-700:hover, .group-hover\:text-green-600:hover,
        .border-purple-500, .hover\:border-purple-700:hover, .group-hover\:text-purple-600:hover,
        .border-yellow-500, .hover\:border-yellow-700:hover, .group-hover\:text-yellow-600:hover,
        .border-red-500, .hover\:border-red-700:hover, .group-hover\:text-red-600:hover,
        .border-indigo-500, .hover\:border-indigo-700:hover, .group-hover\:text-indigo-600:hover,
        .group-hover\:bg-blue-50:hover, .group-hover\:bg-green-50:hover, .group-hover\:bg-purple-50:hover,
        .group-hover\:bg-yellow-50:hover, .group-hover\:bg-red-50:hover, .group-hover\:bg-indigo-50:hover {
            /* Placeholder para Tailwind JIT */
        }
    </style>
@endsection
