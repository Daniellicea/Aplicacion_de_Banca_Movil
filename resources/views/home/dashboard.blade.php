@extends('layouts.app')

@section('title', 'Dashboard - Bankario')

@section('content')
    {{-- 1. Fondo Blanco --}}
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">
        <header class="border-b border-gray-200 bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <h1 class="text-3xl font-extrabold text-blue-600 tracking-wider">BANKARIO</h1>

                <div class="flex items-center gap-8">
                    {{-- INICIO: Menú Desplegable "Mi Perfil" con Activación por HOVER (Cursor) --}}
                    <div x-data="{ open: false }"
                         @mouseover.away="open = false"
                         class="relative">

                        <button @mouseover="open = true" type="button"
                                class="flex items-center p-2 rounded-full bg-blue-50 hover:bg-blue-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">

                            {{-- Icono/Avatar --}}
                            <div class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-600 text-white font-semibold text-sm">
                                {{ substr(session('usuario_nombre') ?? 'U', 0, 1) }}
                            </div>

                            {{-- Nombre del Usuario --}}
                            <span class="ml-2 mr-1 text-sm font-semibold text-gray-700 hidden sm:inline">{{ session('usuario_nombre') ?? 'Usuario' }}</span>

                            {{-- Icono de flecha --}}
                            <svg class="w-4 h-4 ml-1 text-gray-400 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open"
                             @mouseover="open = true"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-64 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 z-50 origin-top-right">

                            {{-- Sección de Usuario Destacada --}}
                            <div class="p-4 border-b border-gray-100">
                                <p class="text-lg font-bold text-gray-900">{{ session('usuario_nombre') ?? 'Usuario' }}</p>
                                <p class="text-xs text-gray-500 font-medium mt-1">Sesión iniciada</p>
                            </div>

                            <div class="py-2">
                                {{-- 1. Opción Administrar Usuarios --}}
                                <a href="{{ route('usuarios.index') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.143" />
                                    </svg>
                                    Administrar Usuarios
                                </a>

                                {{-- 2. Opción Cerrar Sesión --}}
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-gray-100 mt-2 pt-2">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-3 w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-3m0-4v-1a3 3 0 013-3h3m7 3h-2" />
                                        </svg>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- FIN: Menú --}}
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-16">
            <div class="mb-14">
                <h2 class="text-6xl font-extrabold text-gray-900 mb-3">
                    Hola, <span class="text-blue-600">{{ session('usuario_nombre') ?? 'Usuario' }}</span>
                </h2>
                <p class="text-xl text-gray-500 mt-2">Bienvenido a tu banca móvil</p>
            </div>

            {{-- Tarjeta de saldo --}}
            <div class="bg-gradient-to-br from-blue-600 to-cyan-700 rounded-3xl p-10 text-white mb-20 shadow-xl shadow-blue-200 transform hover:scale-[1.01] transition-transform duration-300">
                <p class="text-sm uppercase tracking-widest opacity-90 mb-2 font-medium">Saldo Total Actual</p>
                <p class="text-7xl font-bold mb-10">${{ number_format($totalBalance ?? 0, 2) }}</p>

                <div class="flex gap-12 border-t border-white/50 pt-6">
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider opacity-70 mb-1">Ingresos (último periodo)</p>
                        <p class="text-2xl font-semibold text-green-200">+${{ number_format($income ?? 0, 2) }}</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider opacity-70 mb-1">Gastos (último periodo)</p>
                        <p class="text-2xl font-semibold text-red-300">-${{ number_format($expenses ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-3xl font-bold text-gray-800 mb-8">Nuestros Servicios</h3>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Ruta corregida: users.account --}}
                    <a href="{{ route('users.account') }}"
                       class="block w-full p-8 bg-white border border-gray-200 hover:border-blue-500 transition-all duration-300 rounded-xl shadow-lg group hover:shadow-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-1">Cuentas y Movimientos</h4>
                                <p class="text-sm text-gray-500">Consulta tus saldos y transacciones a detalle.</p>
                            </div>
                            <svg class="w-7 h-7 text-gray-400 group-hover:text-blue-600 transition-colors duration-300 transform group-hover:translate-x-1"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('transactions.transfer') }}"
                       class="block w-full p-8 bg-white border border-gray-200 hover:border-blue-500 transition-all duration-300 rounded-xl shadow-lg group hover:shadow-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-1">Transferencias</h4>
                                <p class="text-sm text-gray-500">Envía dinero de forma segura a otras cuentas.</p>
                            </div>
                            <svg class="w-7 h-7 text-gray-400 group-hover:text-blue-600 transition-colors duration-300 transform group-hover:translate-x-1"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('transactions.qr') }}"
                       class="block w-full p-8 bg-white border border-gray-200 hover:border-blue-500 transition-all duration-300 rounded-xl shadow-lg group hover:shadow-blue-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-2xl font-bold text-gray-900 mb-1">Pagos QR</h4>
                                <p class="text-sm text-gray-500">Escanea o genera códigos para pagos rápidos.</p>
                            </div>
                            <svg class="w-7 h-7 text-gray-400 group-hover:text-blue-600 transition-colors duration-300 transform group-hover:translate-x-1"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
@endsection
