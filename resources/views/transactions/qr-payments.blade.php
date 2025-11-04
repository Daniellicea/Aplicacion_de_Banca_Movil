@extends('layouts.app')

@section('title', 'Pagos QR - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">
        <!-- Header (Estilo BANKARIO) -->
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

                <!-- 1. Escanear QR (Card) -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Escanear QR</h3>
                    <p class="text-gray-500 mb-6">Activa la cámara para escanear y procesar un pago.</p>

                    <!-- Contenedor de la Cámara / Placeholder -->
                    <div id="scannerContainer" class="aspect-square bg-gray-100 rounded-xl flex items-center justify-center mb-6 overflow-hidden relative border-4 border-dashed border-gray-300">

                        <div id="scannerPlaceholder">
                            <!-- Icono Scanner estilo BANKARIO -->
                            <svg class="w-20 h-20 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>

                        <video id="qrVideo" class="absolute inset-0 w-full h-full object-cover hidden" playsinline></video>
                    </div>

                    <!-- Botones de Acción de Cámara -->
                    <button id="scanBtn" class="w-full h-14 text-lg font-bold bg-blue-600 hover:bg-blue-700 text-white transition-all rounded-xl shadow-lg shadow-blue-300/50 transform hover:scale-[1.01] duration-300">
                        Abrir Cámara
                    </button>
                    <button id="stopScanBtn" class="hidden w-full h-14 text-lg font-bold bg-red-500 hover:bg-red-600 text-white transition-all rounded-xl mt-3 shadow-lg shadow-red-300/50">
                        Detener Cámara
                    </button>
                </div>

                <!-- 2. Generar QR (Card) -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <h3 class="text-3xl font-bold text-gray-900 mb-8">Generar QR</h3>

                    <form id="qrForm" class="space-y-6">
                        <div class="space-y-2">
                            <label for="amount" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Monto
                            </label>
                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full h-14 px-5 text-xl font-mono bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors rounded-xl outline-none"
                                required
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Descripción
                            </label>
                            <input
                                id="description"
                                name="description"
                                type="text"
                                placeholder="Concepto del pago"
                                class="w-full h-14 px-5 text-base bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors rounded-xl outline-none"
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full h-14 text-lg font-bold bg-green-500 hover:bg-green-600 text-white transition-all rounded-xl shadow-lg shadow-green-300/50 transform hover:scale-[1.01] duration-300"
                        >
                            Generar Código QR
                        </button>
                    </form>

                    <!-- Contenedor del QR Generado -->
                    <div id="qrCodeContainer" class="hidden mt-10 pt-6 border-t border-gray-200 text-center">
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Código Generado</h4>
                        <div class="bg-white p-4 border-2 border-green-400 rounded-xl max-w-[200px] mx-auto shadow-xl shadow-green-100/70">
                            <img id="qrCodeImage" src="" alt="Código QR" class="w-full rounded-lg" />
                        </div>

                        <div class="mt-4 text-center">
                            <p id="qrAmount" class="font-bold text-2xl text-gray-900 mb-1"></p>
                            <p id="qrDescription" class="text-base text-gray-500"></p>
                        </div>

                        <button id="downloadQrBtn" class="inline-flex items-center gap-2 px-6 py-3 mt-6 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-bold shadow-md shadow-blue-200/50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Descargar QR
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // ************************************************************
        // AVISO: El siguiente código JavaScript se mantiene sin cambios
        // ************************************************************

        const qrForm = document.getElementById('qrForm');
        const qrCodeContainer = document.getElementById('qrCodeContainer');
        const qrCodeImage = document.getElementById('qrCodeImage');
        const qrAmount = document.getElementById('qrAmount');
        const qrDescription = document.getElementById('qrDescription');
        const downloadQrBtn = document.getElementById('downloadQrBtn');

        qrForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const amount = document.getElementById('amount').value;
            const description = document.getElementById('description').value;

            const paymentId = 'PAY-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);

            const qrData = JSON.stringify({
                paymentId: paymentId,
                amount: parseFloat(amount),
                description: description || 'Pago sin descripción',
                timestamp: new Date().toISOString()
            });

            // Usando Quickchart para generar el QR (se mantiene la URL original)
            const qrUrl = `https://quickchart.io/qr?text=${encodeURIComponent(qrData)}&size=400&margin=2`;

            qrCodeImage.src = qrUrl;
            qrAmount.textContent = `$${parseFloat(amount).toFixed(2)} MXN`;
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
                a.download = `QR-Bankario-${Date.now()}.png`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            } catch (error) {
                console.error('Error al descargar QR:', error);
                // Usando un modal/alert en consola en lugar de alert()
                console.error('Error al descargar el código QR');
            }
        });

        const scanBtn = document.getElementById('scanBtn');
        const stopScanBtn = document.getElementById('stopScanBtn');
        const video = document.getElementById('qrVideo');
        const scannerPlaceholder = document.getElementById('scannerPlaceholder');

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

                // Usando un modal/alert en consola en lugar de alert()
                console.error("Alerta de Cámara:", errorMessage);
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
