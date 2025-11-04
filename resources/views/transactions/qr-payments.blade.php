@extends('layouts.app')

@section('title', 'Pagos QR - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">
        <header class="border-b border-gray-200 bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm font-medium hidden sm:inline">Volver</span>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Pagos QR</h1>
                <div class="w-12"></div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-6 py-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-12">
                Pagos <span class="text-blue-600">con QR</span>
            </h2>

            <div class="grid lg:grid-cols-2 gap-8 md:gap-12">

                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Escanear QR</h3>
                    <p class="text-gray-500 mb-8">Utiliza la cámara de tu dispositivo para leer códigos de pago al instante.</p>

                    <div class="aspect-square bg-gray-100 rounded-xl flex flex-col items-center justify-center p-8 mb-8 border-4 border-dashed border-gray-300">
                        <svg class="w-20 h-20 text-blue-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        <p class="text-sm font-medium text-gray-600">Apunta la cámara al código QR.</p>
                    </div>

                    <button class="w-full h-14 text-lg font-bold bg-blue-600 hover:bg-blue-700 text-white transition-all rounded-xl shadow-lg shadow-blue-300/50 transform hover:scale-[1.01] duration-300">
                        Abrir Cámara (Simulado)
                    </button>
                    <p class="text-xs text-gray-400 mt-3 text-center">Nota: La función de cámara requiere permisos del dispositivo.</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-3xl font-bold text-gray-900 mb-8">Generar QR</h3>

                    <form method="POST" action="{{ route('qr-payments.generate') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="amount" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Monto a Recibir ($)
                            </label>
                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                step="0.01"
                                placeholder="Ej. 150.00"
                                class="w-full h-14 px-5 text-xl font-mono bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors rounded-xl outline-none"
                                required
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Descripción / Concepto (Opcional)
                            </label>
                            <input
                                id="description"
                                name="description"
                                type="text"
                                placeholder="Cena, alquiler, etc."
                                class="w-full h-12 px-5 text-base bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors rounded-xl outline-none"
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full h-14 text-lg font-bold bg-green-500 hover:bg-green-600 text-white transition-all rounded-xl shadow-lg shadow-green-300/50 mt-8 transform hover:scale-[1.01] duration-300"
                        >
                            Generar Código QR
                        </button>
                    </form>

                    @if(session('qrCode'))
                        <div class="mt-10 pt-6 border-t border-gray-200">
                            <h4 class="text-xl font-bold text-gray-800 mb-4 text-center">Tu Código QR Generado</h4>
                            <div class="bg-white p-4 border-2 border-green-400 rounded-xl max-w-[200px] mx-auto shadow-xl shadow-green-100/70">
                                <img src="{{ session('qrCode') }}" alt="Código QR de Pago" class="w-full h-auto" />
                            </div>
                            <p class="text-center text-sm text-gray-500 mt-4">Muestra este código para recibir tu pago.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
@endsection
