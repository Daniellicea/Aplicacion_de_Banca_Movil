@extends('layouts.app')

@section('title', 'Operaciones - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 antialiased">

        {{-- Header Mejorado (Estilo Sólido y Limpio) --}}
        <header class="border-b border-gray-200 bg-white sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 text-gray-500 hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm uppercase tracking-wider font-bold">Volver</span>
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Operaciones</h1>
                <div class="w-24"></div>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-6 py-12 md:py-16 animate-fade-in-up" style="animation-delay: 0.1s;">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-12" id="main-title">
                Nueva Transferencia
            </h2>

            {{-- Mensajes de feedback --}}
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-400 text-green-700 rounded-xl font-semibold shadow-md flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-8 p-4 bg-red-50 border border-red-400 text-red-700 rounded-xl font-semibold shadow-md">
                    <p class="font-bold mb-2">Se encontraron los siguientes errores:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Selector de Operación --}}
            <div class="mb-10 flex border-2 border-gray-200 rounded-xl p-1 bg-gray-100 shadow-inner animate-fade-in-up" style="animation-delay: 0.2s;">
                <button
                    type="button"
                    onclick="setOperation('transfer')"
                    id="btn-transfer"
                    class="flex-1 py-3 text-base font-bold transition-all rounded-xl
                           bg-blue-600 text-white shadow-md" {{-- Azul activo --}}
                >
                    Transferencia
                </button>
                <button
                    type="button"
                    onclick="setOperation('deposit')"
                    id="btn-deposit"
                    class="flex-1 py-3 text-base font-bold transition-all rounded-xl
                           text-gray-900 hover:bg-gray-200" {{-- Inactivo --}}
                >
                    Depósito (Generar QR)
                </button>
            </div>

            {{-- Formulario de Operación --}}
            <form method="POST" action="{{ route('transfers.store') }}" id="operation-form" class="space-y-8 mb-16 animate-fade-in-up" style="animation-delay: 0.3s;" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="operation_type" id="operation_type" value="transfer">

                {{-- Campos de Transferencia --}}
                <div id="transfer-fields" class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">

                    <div class="space-y-3 mb-8">
                        <label for="source_account" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                            Cuenta de Origen
                        </label>
                        <select
                            id="source_account"
                            name="source_account"
                            class="w-full h-14 px-4 text-base font-semibold bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                   focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none appearance-none"
                            required
                        >
                            @forelse($userAccounts ?? [] as $account)
                                <option value="{{ $account['id'] ?? $loop->index }}" data-balance="{{ $account['balance'] ?? 0.00 }}">
                                    {{ $account['name'] ?? 'Cuenta Principal' }} (${{ number_format($account['balance'] ?? 0.00, 2) }})
                                </option>
                            @empty
                                <option value="" disabled>No hay cuentas disponibles</option>
                            @endforelse
                        </select>
                        <p class="text-sm text-gray-500 mt-1 font-semibold" id="current-balance-info">Saldo disponible: $0.00</p>
                    </div>

                    <div class="space-y-3">
                        <label for="account" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                            Cuenta Destino
                        </label>
                        <input
                            id="account"
                            name="account"
                            type="text"
                            placeholder="Número de cuenta o CLABE"
                            class="w-full h-14 px-4 text-base bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                   focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
                            required
                        />
                    </div>

                    <div class="space-y-3 mt-8">
                        <label for="amount" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                            Monto ($)
                        </label>
                        <input
                            id="amount"
                            name="amount"
                            type="number"
                            step="0.01"
                            min="0.01"
                            placeholder="0.00"
                            class="w-full h-14 px-4 text-xl font-bold bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                   focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
                            required
                        />
                        <p class="text-sm text-gray-500 mt-1">El monto debe ser mayor a 0</p>
                    </div>

                    <div class="space-y-3 mt-8">
                        <label for="reference" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                            Referencia Numérica (Mín. 7 dígitos)
                        </label>
                        <input
                            id="reference"
                            name="reference"
                            type="text"
                            placeholder="Referencia o Clave de Rastreo"
                            maxlength="15"
                            pattern="[0-9]{7,15}"
                            class="w-full h-14 px-4 text-base bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                   focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
                            required
                        />
                        <p class="text-sm text-gray-500 mt-1">Campo obligatorio para el rastreo de la operación.</p>
                    </div>

                    <div class="space-y-3 mt-8">
                        <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                            Descripción/Concepto (Opcional)
                        </label>
                        <input
                            id="description"
                            name="description"
                            type="text"
                            placeholder="Concepto de la transferencia"
                            class="w-full h-14 px-4 text-base bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                   focus:border-blue-600 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
                        />
                    </div>
                </div>

                {{-- QR de Depósito --}}
                <div id="deposit-qr" class="hidden text-center p-8 bg-white rounded-2xl border border-blue-200 shadow-xl space-y-4">
                    <p class="text-xl font-extrabold text-gray-900">Tu Código QR para Depósitos</p>
                    <p class="text-sm text-gray-500">Pide a otros que escaneen este código para depositarte fondos directamente.</p>

                    <div class="w-48 h-48 mx-auto p-4 bg-white rounded-xl shadow-lg border-4 border-blue-300/50">
                        <div id="qr-code-placeholder" class="w-full h-full text-center flex items-center justify-center text-gray-500">
                            {{-- Placeholder de QR (Aquí se inyectaría la imagen real con JS) --}}
                            <svg class="w-16 h-16 text-blue-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18M3 8h18M3 12h18M3 16h18M3 20h18" /></svg>
                        </div>
                    </div>

                    <p class="text-base font-semibold text-gray-900 pt-4">Tu Cuenta CLABE:</p>
                    <p class="text-2xl font-mono text-blue-600 font-extrabold tracking-wider">
                        {{ auth()->user()->clabe ?? '123456789012345678' }}
                    </p>
                    <p class="text-sm text-gray-500">El QR contiene esta CLABE para el depósito.</p>
                </div>

                {{-- Botón de Acción (Transferencia) - BLANCO CON SOMBRA AZUL --}}
                <button
                    type="submit"
                    id="submit-button"
                    class="w-full h-14 text-lg font-extrabold
                           bg-white hover:bg-gray-100 text-blue-600
                           transition duration-300 rounded-xl
                           shadow-2xl shadow-blue-500/50 border border-gray-200
                           transform hover:scale-[1.005] focus:outline-none focus:ring-4 focus:ring-blue-500/50"
                >
                    Realizar Transferencia
                </button>
            </form>

            {{-- Contactos Recientes --}}
            <div id="recent-contacts-section" class="animate-fade-in-up" style="animation-delay: 0.4s;">
                <h3 class="text-2xl font-extrabold text-gray-900 mb-6 mt-12">Contactos Recientes</h3>

                <div class="space-y-3">
                    @php
                        // Datos de ejemplo para contactos recientes (deberían venir del controlador)
                        $recentContacts = [
                            ['name' => 'María López', 'account' => '012345678901234567'],
                            ['name' => 'Tienda Principal', 'account' => '987654321098765432'],
                        ];
                    @endphp
                    @forelse($recentContacts as $contact)
                        <button
                            type="button"
                            onclick="fillAccount('{{ $contact['account'] }}')"
                            class="w-full p-4 bg-white border border-gray-200 hover:border-blue-600 transition-all rounded-xl text-left shadow-sm hover:shadow-md"
                        >
                            <p class="text-base font-semibold text-gray-900">{{ $contact['name'] }}</p>
                            <p class="text-sm text-gray-500 mt-1 font-mono">{{ $contact['account'] }}</p>
                        </button>
                    @empty
                        <div class="p-6 bg-gray-100 rounded-xl text-center">
                            <p class="text-gray-500">No tienes contactos recientes.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>
        // Inicialización de la librería de QR (asumiendo que está disponible o se cargará)
        function generateQrCode(clabe) {
            const placeholder = document.getElementById('qr-code-placeholder');
            placeholder.innerHTML = `<img src="https://quickchart.io/qr?text=${clabe}&size=400&margin=2" alt="Código QR Depósito" class="w-full h-full object-contain rounded-md"/>`;
        }

        // Función para actualizar el saldo disponible mostrado
        function updateBalanceInfo() {
            const select = document.getElementById('source_account');
            if (select) {
                const selectedOption = select.options[select.selectedIndex];
                const balance = selectedOption ? parseFloat(selectedOption.getAttribute('data-balance')) : 0;
                const formattedBalance = balance.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                document.getElementById('current-balance-info').textContent = `Saldo disponible: $${formattedBalance}`;
            }
        }

        // Función para cambiar entre Transferencia y Depósito
        function setOperation(type) {
            const transferFields = document.getElementById('transfer-fields');
            const depositQr = document.getElementById('deposit-qr');
            const submitButton = document.getElementById('submit-button');
            const mainTitle = document.getElementById('main-title');
            const btnTransfer = document.getElementById('btn-transfer');
            const btnDeposit = document.getElementById('btn-deposit');
            const recentContacts = document.getElementById('recent-contacts-section');

            document.getElementById('operation_type').value = type;
            const accountInput = document.getElementById('account');
            const amountInput = document.getElementById('amount');
            const referenceInput = document.getElementById('reference');
            const sourceAccountSelect = document.getElementById('source_account');

            // Limpieza de clases de los botones
            [btnTransfer, btnDeposit].forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('text-gray-900', 'hover:bg-gray-200');
            });

            if (type === 'transfer') {
                // Modo Transferencia
                mainTitle.textContent = 'Nueva Transferencia';
                submitButton.textContent = 'Realizar Transferencia';

                transferFields.classList.remove('hidden');
                depositQr.classList.add('hidden');
                submitButton.classList.remove('hidden');
                recentContacts.classList.remove('hidden');

                // Estilo activo
                btnTransfer.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btnTransfer.classList.remove('hover:bg-gray-200');

                // Habilitar y requerir campos de transferencia
                accountInput.setAttribute('required', 'required');
                amountInput.setAttribute('required', 'required');
                referenceInput.setAttribute('required', 'required');
                sourceAccountSelect.setAttribute('required', 'required');

                updateBalanceInfo();

            } else {
                // Modo Depósito (Generar QR)
                mainTitle.textContent = 'Generar QR para Depósito';

                transferFields.classList.add('hidden');
                depositQr.classList.remove('hidden');
                submitButton.classList.add('hidden');
                recentContacts.classList.add('hidden');

                // Estilo activo
                btnDeposit.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btnDeposit.classList.remove('hover:bg-gray-200');

                // Deshabilitar campos de transferencia
                accountInput.removeAttribute('required');
                amountInput.removeAttribute('required');
                referenceInput.removeAttribute('required');
                sourceAccountSelect.removeAttribute('required');

                // Generar el QR al cambiar al modo depósito
                const clabe = '{{ auth()->user()->clabe ?? '123456789012345678' }}';
                generateQrCode(clabe);
            }
        }

        // Función para pre-llenar la cuenta con un contacto reciente
        function fillAccount(account) {
            document.getElementById('account').value = account;
        }

        // Validación del formulario
        function validateForm() {
            const operationType = document.getElementById('operation_type').value;

            if (operationType === 'transfer') {
                const amountInput = document.getElementById('amount');
                const amount = parseFloat(amountInput.value);

                const select = document.getElementById('source_account');
                const selectedOption = select.options[select.selectedIndex];
                const currentBalance = parseFloat(selectedOption.getAttribute('data-balance'));

                if (amount <= 0) {
                    alert('El monto debe ser un número positivo mayor a 0.');
                    amountInput.focus();
                    return false;
                }

                if (amount > currentBalance) {
                    alert(`¡Error! El monto de $${amount.toLocaleString('es-MX')} excede el saldo disponible ($${currentBalance.toLocaleString('es-MX')}) en la cuenta seleccionada.`);
                    amountInput.focus();
                    return false;
                }

                const referenceInput = document.getElementById('reference').value.trim();
                const referencePattern = document.getElementById('reference').getAttribute('pattern');
                const regex = new RegExp(referencePattern);

                if (!regex.test(referenceInput)) {
                    alert('La Referencia Numérica debe contener entre 7 y 15 dígitos.');
                    document.getElementById('reference').focus();
                    return false;
                }
            }

            return operationType === 'transfer';
        }

        // Validación visual en tiempo real del monto para transferencia
        document.getElementById('amount')?.addEventListener('input', function() {
            const operationType = document.getElementById('operation_type').value;
            if (operationType !== 'transfer') return;

            const amount = parseFloat(this.value);
            const select = document.getElementById('source_account');
            const currentBalance = parseFloat(select.options[select.selectedIndex].getAttribute('data-balance'));

            // Usamos clases de Tailwind para indicar el error visual
            if (amount <= 0 || amount > currentBalance) {
                this.classList.add('border-red-500', 'ring-2', 'ring-red-200');
            } else {
                // Aquí usamos las clases estándar de Tailwind para el focus
                this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                this.classList.add('focus:border-blue-600', 'focus:ring-blue-200');
            }
        });

        // Escuchar el cambio de cuenta de origen para actualizar el saldo
        document.getElementById('source_account')?.addEventListener('change', updateBalanceInfo);

        document.addEventListener('DOMContentLoaded', () => {
            // Inicializa el saldo
            updateBalanceInfo();
            // Asegura que la operación sea transferencia al cargar
            setOperation('transfer');
        });
    </script>

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
        /* Clase para el error visual */
        .border-red-500 {
            border-color: #ef4444;
        }
    </style>
@endsection
