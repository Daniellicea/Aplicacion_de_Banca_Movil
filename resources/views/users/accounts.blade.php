@extends('layouts.app')

@section('title', 'Cuentas y Movimientos - Bankario')

@section('content')
    <div class="min-h-screen bg-background">
        <!-- Header -->
        <header class="border-b-2 border-border bg-card">
            <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-muted-foreground hover:text-foreground transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm uppercase tracking-wide">Volver</span>
                </a>
                <h1 class="text-2xl font-bold text-foreground">Cuentas y Movimientos</h1>
                <div class="w-24"></div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-12">
            <!-- Título -->
            <h2 class="text-5xl font-bold text-foreground mb-12">Mis Cuentas</h2>

            <!-- Resumen financiero -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-16">
                <div class="bg-card border-2 border-border rounded-lg p-8 text-center">
                    <p class="text-sm uppercase tracking-wide text-muted-foreground mb-2">
                        Ingresos (último periodo)
                    </p>
                    <p class="text-3xl font-bold text-green-600">
                        +${{ number_format($totalIngresos ?? 8500.00) }}
                    </p>
                </div>
                <div class="bg-card border-2 border-border rounded-lg p-8 text-center">
                    <p class="text-sm uppercase tracking-wide text-muted-foreground mb-2">
                        Gastos (último periodo)
                    </p>
                    <p class="text-3xl font-bold text-red-600">
                        -${{ number_format($totalGastos ?? 545.50, 2) }}
                    </p>
                </div>
            </div>

            <!-- Lista de cuentas -->
            <div class="space-y-4 mb-16">
                @foreach($accounts as $account)
                    <div class="bg-card border-2 border-border rounded-lg p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm uppercase tracking-wide text-muted-foreground mb-1">
                                    {{ $account['type'] }}
                                </p>
                                <h3 class="text-2xl font-bold text-foreground">
                                    {{ $account['name'] }}
                                </h3>
                                <p class="text-sm text-muted-foreground mt-1">
                                    {{ $account['number'] }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold text-foreground">
                                    ${{ number_format($account['balance'], 2) }}
                                </p>
                                <p class="text-sm text-muted-foreground mt-1">MXN</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Movimientos recientes -->
            <div>
                <h3 class="text-3xl font-bold text-foreground mb-8">Movimientos Recientes</h3>

                <div class="bg-card border-2 border-border rounded-lg overflow-hidden">
                    @foreach($transactions as $transaction)
                        <div class="p-6 border-b-2 border-border last:border-b-0 hover:bg-secondary transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-base font-semibold text-foreground">
                                        {{ $transaction['description'] }}
                                    </p>
                                    <p class="text-sm text-muted-foreground mt-1">
                                        {{ $transaction['date'] }}
                                    </p>
                                </div>
                                <p class="text-xl font-bold {{ $transaction['type'] === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction['type'] === 'credit' ? '+' : '-' }}${{ number_format(abs($transaction['amount']), 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
@endsection
