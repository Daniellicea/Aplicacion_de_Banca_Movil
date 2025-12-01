@extends('layouts.app')

@section('title', 'Cuentas y Movimientos - Bankario')

@section('content')
<div class="min-h-screen bg-gray-50 antialiased">

<header class="border-b border-gray-200 bg-white/80 backdrop-blur-sm sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-gray-500 hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <span class="text-sm uppercase tracking-wider font-bold">Volver</span>
        </a>
        <h1 class="text-xl font-extrabold text-gray-900">Cuentas y Movimientos</h1>
        <div class="w-24"></div>
    </div>
</header>

@php
/*
  Lectura segura de saldos y movimientos desde sesión.
  NOTA: no reescribimos valores si ya existen.
*/

// Inicializar solo si NO existe
if (session()->has('saldo_real') === false) {
    session(['saldo_real' => 5000.00]);
}
if (session()->has('saldo_ahorros') === false) {
    session(['saldo_ahorros' => 15250.75]);
}

// Obtener valores actuales (siempre desde sesión)
$saldo_real    = session('saldo_real');
$saldo_ahorros = session('saldo_ahorros');

// Movimientos: si no existen, inicializar con ejemplo (solo la primera vez)
if (session()->has('transactions') === false) {
    session([
        'transactions' => [
            ['description'=>'Depósito Nómina','date'=>'2025-10-28','type'=>'credit','amount'=>8500.00],
            ['description'=>'Pago de Luz','date'=>'2025-10-26','type'=>'debit','amount'=>-480.50],
            ['description'=>'Compra OXXO','date'=>'2025-10-24','type'=>'debit','amount'=>-65.00],
        ]
    ]);
}

// Releer siempre (para que cualquier cambio de sesión se refleje)
$transactions = session('transactions', []);

// Build cuentas para mostrar (toman balances directamente de sesión)
$accounts = [
    [
        'type'=>'Cuenta de Ahorro',
        'name'=>'Ahorros Personales',
        'number'=>'1234 5678 9012',
        'balance'=>session('saldo_ahorros'),
        'icon'=>'<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
        'color'=>'bg-green-600'
    ],
    [
        'type'=>'Cuenta Corriente',
        'name'=>'Saldo Principal',
        'number'=>'9876 5432 1098',
        'balance'=>session('saldo_real'),
        'icon'=>'<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>',
        'color'=>'bg-blue-600'
    ]
];

@endphp


<main class="max-w-7xl mx-auto px-6 py-12 md:py-16">

<h2 class="text-4xl md:text-5xl font-extrabold mb-12">
Mis <span class="text-blue-600">Cuentas</span>
</h2>

<div class="grid md:grid-cols-2 gap-6 mb-16">
@foreach($accounts as $account)
    <div class="bg-white border rounded-2xl p-6 shadow-xl">
        <div class="flex justify-between">
            <div>
                <div class="flex gap-3 items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white {{ $account['color'] }}">
                        {!! $account['icon'] !!}
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500 font-bold">{{ $account['type'] }}</p>
                        <h3 class="text-2xl font-extrabold">{{ $account['name'] }}</h3>
                    </div>
                </div>
                <p class="font-mono text-gray-400 mt-3">**** {{ substr(str_replace(' ','',$account['number']), -4) }}</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-extrabold">${{ number_format($account['balance'],2) }}</p>
                <p class="text-sm text-gray-500">MXN</p>
            </div>
        </div>
    </div>
@endforeach
</div>

<h3 class="text-3xl font-extrabold mb-8">
Historial de <span class="text-blue-600">Transacciones</span>
</h3>

<div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    @forelse($transactions as $t)
        <div class="p-4 border-b flex justify-between">
            <div>
                <p class="font-bold">{{ $t['description'] }}</p>
                <p class="text-sm text-gray-500">{{ $t['date'] }}</p>
            </div>
            <div class="{{ $t['type']=='credit' ? 'text-green-600' : 'text-red-600' }} font-bold">
                {{ $t['type']=='credit' ? '+' : '-' }}${{ number_format(abs($t['amount']),2) }}
            </div>
        </div>
    @empty
        <div class="p-6 text-center text-gray-500">
            <p>No hay movimientos recientes en tus cuentas.</p>
        </div>
    @endforelse
</div>

</main>
</div>
@endsection
