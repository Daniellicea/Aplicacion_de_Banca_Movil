@extends('layouts.app')

@section('title', 'Pagos QR - Bankario')

{{-- Ajuste de CSS para usar solo clases y colores fijos --}}
@section('head_extra')
    <style>
        /* Estilo para el contenedor del scanner cuando está activo */
        .scanner-active {
            border-color: #2563eb !important; /* blue-600 */
            background-color: #ffffff !important; /* white */
        }
        /* Estilo para el contorno de enfoque del QR */
        #scannerContainer::after {
            content: '';
            position: absolute;
            top: 20%;
            left: 20%;
            width: 60%;
            height: 60%;
            border: 2px solid transparent;
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.4);
            pointer-events: none;
            transition: box-shadow 0.5s;
        }
        .scanner-active #scannerContainer::after {
            box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.6);
        }

        /* Animación de entrada */
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

@section('content')
    <div class="min-h-screen bg-gray-50 antialiased">

        {{-- Header Sólido --}}
        <header class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 text-gray-500 hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm uppercase tracking-wider font-bold hidden sm:inline">Volver</span>
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Pagos QR</h1>
                <div class="w-12"></div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-6 py-12 md:py-16 animate-fade-in-up">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-12">
                Pagos <span class="text-blue-600">con QR</span>
            </h2>

            <div class="grid lg:grid-cols-2 gap-8 md:gap-12">

                {{-- Tarjeta: Escanear QR --}}
                <div class="bg-white border border-gray-200 rounded-3xl p-8 md:p-10 shadow-3xl shadow-blue-200/50 hover:shadow-blue-300/60 transition-shadow duration-300">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10a2 2 0 002 2h12a2 2 0 002-2V7M4 7h16M4 7l2-2h12l2 2M12 18v-6"/></svg>
                        Escanear QR
                    </h3>
                    <p class="text-gray-500 mb-6 text-lg">Activa la cámara para escanear y procesar un pago de forma instantánea.</p>

                    <div id="scannerContainer" class="aspect-square bg-gray-100 rounded-2xl flex items-center justify-center mb-6 overflow-hidden relative border-4 border-dashed border-gray-300 transition-colors duration-300">
                        <div id="scannerPlaceholder">
                            {{-- Icono Scanner estilo BANKARIO --}}
                            <svg class="w-20 h-20 text-blue-600 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            <p class="text-sm text-gray-500 mt-3">Presiona "Abrir Cámara"</p>
                        </div>
                        <video id="qrVideo" class="absolute inset-0 w-full h-full object-cover hidden" playsinline></video>
                    </div>

                    <button id="scanBtn"
                            class="w-full h-14 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                                   hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                                   shadow-xl shadow-blue-500/40 transform hover:scale-[1.01]">
                        Abrir Cámara
                    </button>
                    <button id="stopScanBtn"
                            class="hidden w-full h-14 text-lg font-extrabold bg-red-600 hover:bg-red-700 text-white transition-all rounded-xl mt-3 shadow-lg shadow-red-300/50 transform hover:scale-[1.01]">
                        Detener Cámara
                    </button>
                </div>

                {{-- Tarjeta: Generar QR y Código de Barras --}}
                <div class="bg-white border border-gray-200 rounded-3xl p-8 md:p-10 shadow-3xl shadow-green-200/50 hover:shadow-green-300/60 transition-shadow duration-300">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Generar Código
                    </h3>

                    {{-- Mostrar Saldo Disponible --}}
                    <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl">
                        <p class="text-sm font-bold text-gray-600 mb-2">💰 Saldo Disponible Total:</p>
                        <p class="text-3xl font-extrabold text-blue-600">${{ number_format($saldo_total ?? 0, 2) }} MXN</p>
                        <div class="mt-3 pt-3 border-t border-blue-200 grid grid-cols-2 gap-2 text-xs text-gray-600">
                            <div>
                                <span class="font-semibold">Principal:</span>
                                <span class="ml-1">${{ number_format($saldo_real ?? 0, 2) }}</span>
                            </div>
                            <div>
                                <span class="font-semibold">Ahorros:</span>
                                <span class="ml-1">${{ number_format($saldo_ahorros ?? 0, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <form id="qrForm" class="space-y-6">
                        {{-- Monto --}}
                        <div class="space-y-2">
                            <label for="amount" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Monto ($)
                            </label>
                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                step="0.01"
                                min="0.01"
                                max="{{ $saldo_total ?? 0 }}"
                                placeholder="0.00"
                                class="w-full h-14 px-5 text-xl font-mono bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                       focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
                                required
                            />
                            <p id="amountError" class="hidden text-red-600 text-sm font-semibold flex items-center gap-1 mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="amountErrorText"></span>
                            </p>
                        </div>

                        {{-- Descripción --}}
                        <div class="space-y-2">
                            <label for="description" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Descripción
                            </label>
                            <input
                                id="description"
                                name="description"
                                type="text"
                                placeholder="Concepto del pago"
                                class="w-full h-14 px-5 text-base bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                       focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
                            />
                        </div>

                        {{-- Botones divididos --}}
                        <div class="grid grid-cols-2 gap-3">
                            <button
                                type="submit"
                                data-type="qr"
                                class="h-14 text-base font-extrabold bg-blue-600 hover:bg-blue-700 text-white transition-all rounded-xl shadow-xl shadow-blue-400/50 transform hover:scale-[1.01] duration-300 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                                Código QR
                            </button>
                            <button
                                type="submit"
                                data-type="barcode"
                                class="h-14 text-base font-extrabold bg-green-600 hover:bg-green-700 text-white transition-all rounded-xl shadow-xl shadow-green-400/50 transform hover:scale-[1.01] duration-300 flex items-center justify-center gap-2"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                Cód. Barras
                            </button>
                        </div>
                    </form>

                    <div id="qrCodeContainer" class="hidden mt-10 pt-8 border-t border-gray-200 text-center">
                        <h4 class="text-xl font-extrabold text-gray-900 mb-4">Tu código está listo</h4>
                        <div class="bg-white p-4 border-2 border-green-500 rounded-xl max-w-[280px] mx-auto shadow-2xl shadow-green-200/70">
                            <img id="qrCodeImage" src="" alt="Código de Pago" class="w-full rounded-lg" />
                        </div>

                        <div class="mt-4 text-center">
                            <p id="qrAmount" class="font-extrabold text-3xl text-blue-600 mb-1"></p>
                            <p id="qrDescription" class="text-base text-gray-500"></p>
                        </div>

                        <button id="downloadQrBtn" class="inline-flex items-center gap-2 px-8 py-3 mt-6 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-extrabold shadow-md shadow-blue-300/50 transform hover:scale-[1.01]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Descargar Código
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Script de Lógica --}}
    <script>
        // Saldo disponible desde Laravel
        const SALDO_TOTAL = {{ $saldo_total ?? 0 }};

        const qrForm = document.getElementById('qrForm');
        const qrCodeContainer = document.getElementById('qrCodeContainer');
        const qrCodeImage = document.getElementById('qrCodeImage');
        const qrAmount = document.getElementById('qrAmount');
        const qrDescription = document.getElementById('qrDescription');
        const downloadQrBtn = document.getElementById('downloadQrBtn');
        const amountInput = document.getElementById('amount');
        const amountError = document.getElementById('amountError');
        const amountErrorText = document.getElementById('amountErrorText');

        // Validación en tiempo real
        amountInput.addEventListener('input', function() {
            const value = parseFloat(this.value);

            // Limpiar error
            amountError.classList.add('hidden');
            this.classList.remove('border-red-500', 'focus:ring-red-200');

            // Validar número negativo
            if (value < 0) {
                this.value = '';
                showError('No se permiten montos negativos');
                return;
            }

            // Validar que no sea cero
            if (value === 0) {
                showError('El monto debe ser mayor a $0.00');
                return;
            }

            // Validar saldo insuficiente
            if (value > SALDO_TOTAL) {
                showError(`⚠️ Saldo insuficiente. Disponible: $${SALDO_TOTAL.toFixed(2)} MXN`);
                return;
            }
        });

        function showError(message) {
            amountErrorText.textContent = message;
            amountError.classList.remove('hidden');
            amountInput.classList.add('border-red-500', 'focus:ring-red-200');
        }

        qrForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const amount = parseFloat(amountInput.value);

            // Validaciones antes de enviar
            if (!amount || amount <= 0) {
                showError('Ingresa un monto válido mayor a $0.00');
                amountInput.focus();
                return;
            }

            if (amount > SALDO_TOTAL) {
                showError(`⚠️ Saldo insuficiente. Disponible: $${SALDO_TOTAL.toFixed(2)} MXN`);
                amountInput.focus();
                return;
            }

            // Determinar qué botón fue presionado
            const clickedButton = e.submitter;
            const codeType = clickedButton.getAttribute('data-type');

            const description = document.getElementById('description').value;
            const paymentId = 'PAY-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);

            let codeUrl;

            if (codeType === 'qr') {
                // Generar código QR
                const qrData = JSON.stringify({
                    paymentId: paymentId,
                    amount: amount,
                    description: description || 'Pago sin descripción',
                    timestamp: new Date().toISOString()
                });

                codeUrl = `https://quickchart.io/qr?text=${encodeURIComponent(qrData)}&size=400&margin=2`;
            } else {
                // Generar código de barras
                codeUrl = `https://quickchart.io/barcode?text=${encodeURIComponent(paymentId)}&type=code128&width=400&height=100`;
            }

            qrCodeImage.src = codeUrl;
            qrCodeImage.alt = codeType === 'qr' ? 'Código QR de Pago' : 'Código de Barras de Pago';
            qrAmount.textContent = `$${amount.toFixed(2)} MXN`;
            qrDescription.textContent = description || 'Sin descripción';
            qrCodeContainer.classList.remove('hidden');

            qrCodeContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });

        downloadQrBtn.addEventListener('click', async function() {
            try {
                const response = await fetch(qrCodeImage.src);
                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `Codigo-Bankario-${Date.now()}.png`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            } catch (error) {
                console.error('Error al descargar código:', error);
                alert('Error al descargar el código');
            }
        });

        // === Scanner QR Code ===
        const scanBtn = document.getElementById('scanBtn');
        const stopScanBtn = document.getElementById('stopScanBtn');
        const video = document.getElementById('qrVideo');
        const scannerPlaceholder = document.getElementById('scannerPlaceholder');
        const scannerContainer = document.getElementById('scannerContainer');

        let stream = null;

        scanBtn.addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment',
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                });

                video.srcObject = stream;
                await video.play();

                scannerPlaceholder.classList.add('hidden');
                video.classList.remove('hidden');
                scannerContainer.classList.add('scanner-active');

                scanBtn.classList.add('hidden');
                stopScanBtn.classList.remove('hidden');

            } catch (error) {
                console.error('Error al acceder a la cámara:', error);

                let errorMessage = 'No se pudo acceder a la cámara.';

                if (error.name === 'NotAllowedError') {
                    errorMessage = 'Permisos de cámara denegados. Por favor, permite el acceso a la cámara en la configuración de tu navegador.';
                } else if (error.name === 'NotFoundError') {
                    errorMessage = 'No se encontró ninguna cámara en este dispositivo.';
                } else if (error.name === 'NotReadableError') {
                    errorMessage = 'La cámara está siendo utilizada por otra aplicación.';
                }

                alert(errorMessage);
            }
        });

        stopScanBtn.addEventListener('click', function() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }

            video.srcObject = null;
            video.classList.add('hidden');
            scannerPlaceholder.classList.remove('hidden');
            scannerContainer.classList.remove('scanner-active');

            scanBtn.classList.remove('hidden');
            stopScanBtn.classList.add('hidden');
        });

        window.addEventListener('beforeunload', function() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
@endsection
