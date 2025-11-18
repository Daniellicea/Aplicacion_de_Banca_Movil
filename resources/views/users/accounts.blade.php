@extends('layouts.app')

@section('title', 'Cuentas y Movimientos - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 antialiased">

        {{-- Header Mejorado --}}
        <header class="border-b border-gray-200 bg-white/80 backdrop-blur-sm sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 text-gray-500 hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm uppercase tracking-wider font-bold">Volver</span>
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Cuentas y Movimientos</h1>
                <div class="w-24"></div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-12 md:py-16 animate-fade-in-up">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-12">
                Mis <span class="text-blue-600">Cuentas</span>
            </h2>

            @php
                // Tomar el saldo del dashboard
                $saldo_real = session('saldo_real', 5000.00);

                // Definir cuentas con saldo dinámico
                $accounts = [
                    [
                        'type' => 'Cuenta de Ahorro',
                        'name' => 'Ahorros Personales',
                        'number' => '1234 5678 9012',
                        'balance' => 15250.75,
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                        // Mantener bg-green-600 ya que es un color específico para 'Ahorro'
                        'color' => 'bg-green-600'
                    ],
                    [
                        'type' => 'Cuenta Corriente',
                        'name' => 'Saldo Principal',
                        'number' => '9876 5432 1098',
                        'balance' => $saldo_real,
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>',
                        // Usar blue-600 como color primario
                        'color' => 'bg-blue-600'
                    ],
                ];

                // Simulación de Transacciones si no están definidas
                $transactions = session('transactions', [
                    ['description' => 'Pago de Servicios - Netflix', 'date' => '2025-11-15', 'type' => 'debit', 'amount' => 189.00],
                    ['description' => 'Transferencia recibida (Juan D.)', 'date' => '2025-11-14', 'type' => 'credit', 'amount' => 850.50],
                    ['description' => 'Compra en Supermercado', 'date' => '2025-11-14', 'type' => 'debit', 'amount' => 450.00],
                    ['description' => 'Depósito de Nómina', 'date' => '2025-11-01', 'type' => 'credit', 'amount' => 12000.00],
                ]);
            @endphp

            <div class="grid md:grid-cols-2 gap-6 mb-16">
                @foreach($accounts as $account)
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 md:p-8 shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="flex items-start justify-between">
                            {{-- Información de la Cuenta --}}
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white {{ $account['color'] }} shadow-md">
                                        {!! $account['icon'] !!}
                                    </div>
                                    <div>
                                        <p class="text-xs uppercase tracking-widest text-gray-500 font-bold">{{ $account['type'] }}</p>
                                        <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ $account['name'] }}</h3>
                                    </div>
                                </div>

                                <p class="text-sm font-mono text-gray-500 mt-3 p-1 bg-gray-100 inline-block rounded-md">
                                    **** **** {{ substr(str_replace(' ', '', $account['number']), -4) }}
                                </p>
                            </div>

                            {{-- Saldo --}}
                            <div class="text-right flex-shrink-0 pt-1">
                                <p class="text-3xl font-extrabold text-gray-900 tracking-tight">${{ number_format($account['balance'], 2) }}</p>
                                <p class="text-sm text-gray-500 font-semibold mt-1">MXN</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{--- ---}}

            <div class="mt-12">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-8">
                    Historial de <span class="text-blue-600">Transacciones</span>
                </h3>

                {{-- Tabla de Movimientos (Diseño de lista moderna) --}}
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-xl">

                    {{-- Encabezados (Solo visible en desktop) --}}
                    <div class="hidden sm:grid grid-cols-12 gap-4 p-4 text-xs uppercase tracking-widest font-bold text-gray-500 border-b border-gray-200 bg-gray-100">
                        <div class="col-span-4">Descripción</div>
                        <div class="col-span-3">Fecha</div>
                        <div class="col-span-3 text-center">Tipo</div>
                        <div class="col-span-2 text-right">Monto</div>
                    </div>

                    {{-- Movimientos --}}
                    @forelse($transactions as $transaction)
                        <div class="p-4 md:p-6 border-b border-gray-200 last:border-b-0 hover:bg-gray-100 transition-colors cursor-pointer sm:grid grid-cols-12 gap-4 items-center">

                            {{-- Descripción & Monto (Mobile/Desktop) --}}
                            <div class="col-span-4">
                                <p class="text-base font-semibold text-gray-900">{{ $transaction['description'] }}</p>
                            </div>

                            {{-- Fecha --}}
                            <div class="col-span-3 hidden sm:block">
                                <p class="text-sm text-gray-500 font-mono">{{ $transaction['date'] }}</p>
                            </div>

                            {{-- Tipo --}}
                            <div class="col-span-3 text-center hidden sm:block">
                        <span class="text-xs font-bold px-3 py-1 rounded-full
                            @if($transaction['type'] === 'credit')
                                bg-green-100 text-green-700
                            @else
                                bg-red-100 text-red-700
                            @endif
                        ">
                            {{ $transaction['type'] === 'credit' ? 'INGRESO' : 'EGRESO' }}
                        </span>
                            </div>

                            {{-- Monto --}}
                            <div class="col-span-2 text-right">
                                <p class="text-xl font-extrabold
                            @if($transaction['type'] === 'credit')
                                text-green-600
                            @else
                                text-red-600
                            @endif
                        ">
                                    {{ $transaction['type'] === 'credit' ? '+' : '-' }}${{ number_format(abs($transaction['amount']), 2) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            <p>No hay movimientos recientes en tus cuentas.</p>
                        </div>
                    @endforelse
                </div>
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
    </style>
@endsection
