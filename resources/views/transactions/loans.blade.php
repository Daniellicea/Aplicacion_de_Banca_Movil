@extends('layouts.app')

@section('title', 'Préstamos - Bankario')

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
                <h1 class="text-xl font-extrabold text-gray-900">Gestión de Préstamos</h1>
                <div class="w-24"></div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-6 py-12 md:py-16 animate-fade-in-up">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-12">
                Simula y Gestiona tus <span class="text-blue-600">Préstamos</span>
            </h2>

            <div class="grid lg:grid-cols-2 gap-8 mb-16">

                {{-- 1. Calculadora de préstamos --}}
                <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2h-1a2 2 0 00-2 2v3m-2 4h10a.5.5 0 00.5-.5V12a.5.5 0 00-.5-.5h-1a3 3 0 00-3-3h-1m-2 4v0"/></svg>
                        Calculadora Rápida
                    </h3>

                    <form method="POST" action="{{ route('loans.calculate') }}" class="space-y-6">
                        @csrf

                        {{-- Monto Solicitado --}}
                        <div class="space-y-2">
                            <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                                Monto Solicitado ($)
                            </label>
                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                step="1000"
                                placeholder="Ej: 50000"
                                class="w-full h-14 px-4 text-lg font-semibold bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                       focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none"
                                required
                            />
                        </div>

                        {{-- Plazo (meses) --}}
                        <div class="space-y-2">
                            <label for="months" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                                Plazo (meses)
                            </label>
                            <input
                                id="months"
                                name="months"
                                type="number"
                                min="6"
                                max="60"
                                placeholder="Ej: 12"
                                class="w-full h-14 px-4 text-lg font-semibold bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                       focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none"
                                required
                            />
                        </div>

                        {{-- Botón Calcular (Primario) --}}
                        <button
                            type="submit"
                            class="w-full h-14 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                                   hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                                   shadow-lg shadow-blue-500/40 mt-8 transform hover:scale-[1.005]"
                        >
                            Calcular Pago Mensual
                        </button>
                    </form>

                    {{-- Resultados del Cálculo --}}
                    @if(session('calculation'))
                        <div class="mt-8 p-6 bg-gray-100 rounded-xl space-y-3 border border-gray-200/70 shadow-inner">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-semibold text-base">Pago mensual estimado:</span>
                                <span class="text-xl font-extrabold text-blue-600">${{ number_format(session('calculation')['monthlyPayment'], 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-semibold text-base">Monto Total a pagar:</span>
                                <span class="text-lg font-extrabold text-gray-900">${{ number_format(session('calculation')['total'], 2) }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- 2. Préstamos activos --}}
                <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 shadow-xl">
                    <h3 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tus Préstamos Activos
                    </h3>

                    @if(count($activeLoans) > 0)
                        <div class="space-y-6">
                            @foreach($activeLoans as $loan)
                                <div class="p-6 bg-gray-100 rounded-xl border border-gray-200/70 shadow-md transition-shadow duration-200 hover:shadow-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <p class="text-base uppercase tracking-wider text-gray-500 font-semibold">{{ $loan['type'] }}</p>
                                        <span class="text-xl font-extrabold text-blue-600">${{ number_format($loan['amount'], 2) }}</span>
                                    </div>

                                    <div class="space-y-2 text-sm pt-4 border-t border-gray-200">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Monto Restante:</span>
                                            <span class="font-bold text-gray-900">${{ number_format($loan['remaining'], 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Tasa de Interés:</span>
                                            <span class="font-bold text-gray-900">{{ $loan['rate'] }}%</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Próximo pago:</span>
                                            <span class="font-bold text-gray-900">{{ $loan['nextPayment'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 bg-gray-100 rounded-xl text-center border-dashed border-2 border-gray-300">
                            <p class="text-lg font-semibold text-gray-500">
                                ¡Felicidades! No tienes préstamos pendientes.
                            </p>
                            <p class="text-sm text-gray-500 mt-2">
                                Puedes iniciar una nueva solicitud cuando lo necesites.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 3. Solicitar nuevo préstamo (CTA) --}}
            <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 text-center shadow-2xl shadow-blue-200/50 hover:shadow-blue-300/60 transition-shadow duration-300">
                <h3 class="text-3xl font-extrabold text-gray-900 mb-4">¿Necesitas Financiamiento?</h3>
                <p class="text-gray-500 mb-6 text-lg max-w-2xl mx-auto">
                    Aplica en línea para un nuevo préstamo personal o automotriz. Recibe una pre-aprobación en minutos.
                </p>

                {{-- Botón con estilo Primary (Gradiente/Elevado) --}}
                <button
                    class="h-14 px-10 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                           hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                           shadow-xl shadow-blue-500/40 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-blue-600/50">
                    Iniciar Solicitud de Préstamo
                </button>
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


Este código utiliza una paleta de colores estándar de Tailwind (principalmente `blue-600` para el énfasis y varios tonos de `gray` para fondos y texto secundario).

¿Qué otra vista o componente te gustaría que adapte?
