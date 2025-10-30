@extends('layouts.app')

@section('title', 'Dashboard - Bankario')

@section('content')
    {{-- 1. Fondo Blanco --}}
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">
        <header class="border-b border-gray-200 bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <h1 class="text-3xl font-extrabold text-blue-600 tracking-wider">BANKARIO</h1>

                <div class="flex items-center gap-8">
                    <a href="{{ route('usuarios.index') }}"
                       class="flex items-center gap-2 text-sm uppercase font-medium tracking-widest text-gray-600 hover:text-blue-600 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" class="w-5 h-5 text-blue-600">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        Administrar Usuarios
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-sm uppercase font-medium tracking-widest text-gray-600 hover:text-red-500 transition-colors duration-200">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-16">
            <div class="mb-14">
                <h2 class="text-6xl font-extrabold text-gray-900 mb-3">
                    Hola, <span class="text-blue-600">{{ session('usuario_nombre') ?? 'Usuario' }}</span>
                </h2>
                <p class="text-xl text-gray-500">Bienvenido a tu banca móvil</p>
            </div>

            {{-- Diseño de tarjeta de saldo más moderno para fondo claro --}}
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

                {{-- Eliminado el botón duplicado "Administrar Usuarios" --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('accounts') }}"
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
