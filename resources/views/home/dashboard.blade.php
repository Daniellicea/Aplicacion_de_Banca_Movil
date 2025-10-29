@extends('layouts.app')

@section('title', 'Dashboard - Bankario')

@section('content')
    <div class="min-h-screen bg-background">
        <!-- Header -->
        <header class="border-b-2 border-border bg-card">
            <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-foreground">Bankario</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm uppercase tracking-wide text-muted-foreground hover:text-foreground transition-colors">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-12">
            <!-- Saludo -->
            <div class="mb-12">
                <h2 class="text-6xl font-bold text-foreground mb-4">Hola, {{ $user->name }}</h2>
                <p class="text-xl text-muted-foreground">Bienvenido a tu banca móvil</p>
            </div>

            <!-- Tarjeta de saldo -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-700 rounded-2xl p-12 text-white mb-16 shadow-xl">
                <p class="text-sm uppercase tracking-wider opacity-80 mb-2">Saldo Total</p>
                <p class="text-6xl font-bold mb-8">${{ number_format($totalBalance, 2) }}</p>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider opacity-60 mb-1">Ingresos</p>
                        <p class="text-xl font-semibold">+${{ number_format($income, 2) }}</p>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs uppercase tracking-wider opacity-60 mb-1">Gastos</p>
                        <p class="text-xl font-semibold">-${{ number_format($expenses, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Módulos -->
            <div>
                <h3 class="text-3xl font-bold text-foreground mb-8">Servicios</h3>

                <div class="space-y-3">
                    <!-- Cuentas -->
                    <a href="{{ route('accounts') }}"
                       class="block w-full p-6 bg-card border-2 border-border hover:border-foreground transition-all rounded-lg group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-foreground mb-1">Cuentas y Movimientos</h4>
                                <p class="text-sm text-muted-foreground">Consulta tus saldos y transacciones</p>
                            </div>
                            <svg class="w-6 h-6 text-muted-foreground group-hover:text-foreground transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <!-- Las demás rutas están comentadas temporalmente -->

                    <a href="{{ route('transactions.transfer') }}" class="block w-full p-6 bg-card border-2 border-border hover:border-foreground transition-all rounded-lg group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-foreground mb-1">Transferencias</h4>
                                <p class="text-sm text-muted-foreground">Envía dinero a otras cuentas</p>
                            </div>
                            <svg class="w-6 h-6 text-muted-foreground group-hover:text-foreground transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('transactions.qr') }}" class="block w-full p-6 bg-card border-2 border-border hover:border-foreground transition-all rounded-lg group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-foreground mb-1">Pagos QR</h4>
                                <p class="text-sm text-muted-foreground">Escanea o genera códigos QR</p>
                            </div>
                            <svg class="w-6 h-6 text-muted-foreground group-hover:text-foreground transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>


                    {{--
                    <a href="{{ route('cards') }}" class="block w-full p-6 bg-card border-2 border-border hover:border-foreground transition-all rounded-lg group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-foreground mb-1">Gestión de Tarjetas</h4>
                                <p class="text-sm text-muted-foreground">Administra tus tarjetas de débito y crédito</p>
                            </div>
                            <svg class="w-6 h-6 text-muted-foreground group-hover:text-foreground transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('loans') }}" class="block w-full p-6 bg-card border-2 border-border hover:border-foreground transition-all rounded-lg group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-foreground mb-1">Préstamos</h4>
                                <p class="text-sm text-muted-foreground">Solicita y gestiona tus préstamos</p>
                            </div>
                            <svg class="w-6 h-6 text-muted-foreground group-hover:text-foreground transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('security') }}" class="block w-full p-6 bg-card border-2 border-border hover:border-foreground transition-all rounded-lg group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-foreground mb-1">Seguridad (2FA)</h4>
                                <p class="text-sm text-muted-foreground">Configura la autenticación de dos factores</p>
                            </div>
                            <svg class="w-6 h-6 text-muted-foreground group-hover:text-foreground transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('support') }}" class="block w-full p-6 bg-card border-2 border-border hover:border-foreground transition-all rounded-lg group">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-foreground mb-1">Soporte en Línea</h4>
                                <p class="text-sm text-muted-foreground">Obtén ayuda y contacta con nosotros</p>
                            </div>
                            <svg class="w-6 h-6 text-muted-foreground group-hover:text-foreground transition-colors"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                    --}}
                </div>
            </div>
        </main>
    </div>
@endsection
