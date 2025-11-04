@extends('layouts.app')

@section('title', 'Pagos QR - Bankario')

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
                <h1 class="text-2xl font-bold text-foreground">Pagos QR</h1>
                <div class="w-24"></div>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-6 py-12">
            <h2 class="text-5xl font-bold text-foreground mb-12">Pagos con QR</h2>

            <div class="grid md:grid-cols-2 gap-8">

                <div class="bg-card border-2 border-border rounded-lg p-8">
                    <h3 class="text-2xl font-bold text-foreground mb-6">Escanear QR</h3>

                    <div id="scannerContainer" class="aspect-square bg-secondary rounded-lg flex items-center justify-center mb-6 overflow-hidden relative">

                        <div id="scannerPlaceholder">
                            <svg class="w-24 h-24 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>

                        <video id="qrVideo" class="absolute inset-0 w-full h-full object-cover hidden" playsinline></video>
                    </div>

                    <button id="scanBtn" class="w-full h-14 text-base font-semibold bg-primary hover:bg-primary/90 text-primary-foreground transition-all rounded-lg">
                        Abrir Cámara
                    </button>
                    <button id="stopScanBtn" class="hidden w-full h-14 text-base font-semibold bg-red-500 hover:bg-red-600 text-white transition-all rounded-lg mt-2">
                        Detener Cámara
                    </button>
                </div>

                <!-- Generar QR -->
                <div class="bg-card border-2 border-border rounded-lg p-8">
                    <h3 class="text-2xl font-bold text-foreground mb-6">Generar QR</h3>

                    <form id="qrForm" class="space-y-6">
                        <div class="space-y-3">
                            <label for="amount" class="block text-sm font-medium text-foreground uppercase tracking-wide">
                                Monto
                            </label>
                            <input
                                id="amount"
                                name="amount"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full h-14 px-4 text-base bg-background border-2 border-border focus:border-foreground transition-colors rounded-lg outline-none"
                                required
                            />
                        </div>

                        <div class="space-y-3">
                            <label for="description" class="block text-sm font-medium text-foreground uppercase tracking-wide">
                                Descripción
                            </label>
                            <input
                                id="description"
                                name="description"
                                type="text"
                                placeholder="Concepto del pago"
                                class="w-full h-14 px-4 text-base bg-background border-2 border-border focus:border-foreground transition-colors rounded-lg outline-none"
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full h-14 text-base font-semibold bg-primary hover:bg-primary/90 text-primary-foreground transition-all rounded-lg"
                        >
                            Generar Código QR
                        </button>
                    </form>

                    <div id="qrCodeContainer" class="hidden mt-6 p-6 bg-secondary rounded-lg text-center">
                        <img id="qrCodeImage" src="" alt="Código QR" class="w-full mb-4 rounded-lg" />
                        <div class="text-sm text-muted-foreground mb-2">
                            <p id="qrAmount" class="font-bold text-lg text-foreground"></p>
                            <p id="qrDescription" class="text-sm"></p>
                        </div>
                        <button id="downloadQrBtn" class="inline-flex items-center gap-2 px-6 py-3 bg-foreground text-background rounded-lg hover:opacity-90 transition-opacity font-medium">
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
                alert('Error al descargar el código QR');
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
