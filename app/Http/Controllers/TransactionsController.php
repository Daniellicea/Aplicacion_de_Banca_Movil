<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function loans()
    {
        return view('transactions.loans');
    }

    public function qr()
    {
        // Inicializar saldos si no existen
        if (!session()->has('saldo_real')) session(['saldo_real' => 5000.00]);
        if (!session()->has('saldo_ahorros')) session(['saldo_ahorros' => 15250.75]);

        $saldo_real = session('saldo_real');
        $saldo_ahorros = session('saldo_ahorros');

        // Saldo total disponible
        $saldo_total = $saldo_real + $saldo_ahorros;

        return view('transactions.qr-payments', [
            'saldo_real' => $saldo_real,
            'saldo_ahorros' => $saldo_ahorros,
            'saldo_total' => $saldo_total
        ]);
    }
    /* ===========================
       VISTA DE TRANSFERENCIA
       =========================== */

    public function transfer()
    {
        /* =========
           SALDOS
           ========= */

        if (!session()->has('saldo_real')) session(['saldo_real' => 5000.00]);
        if (!session()->has('saldo_ahorros')) session(['saldo_ahorros' => 15250.75]);

        /* =========
           CUENTAS
           ========= */

        $cuentas = [
            [
                'id' => 'principal',
                'name' => 'Saldo Principal',
                'balance' => session('saldo_real')
            ],
            [
                'id' => 'ahorros',
                'name' => 'Ahorros Personales',
                'balance' => session('saldo_ahorros')
            ]
        ];

        /* ============
           MIS DATOS
           ============ */

        $saldo = session('saldo_real');
        $saldo_ahorros = session('saldo_ahorros');
        $transactions = session('transactions', []);

        $recentContacts = [
            ['name' => 'Juan Pérez', 'account' => '1234567890'],
            ['name' => 'María López', 'account' => '0987654321'],
            ['name' => 'Carlos García', 'account' => '1122334455'],
        ];

        return view('transactions.transfers', [
            'saldo' => $saldo,
            'saldo_ahorros' => $saldo_ahorros,
            'transactions' => $transactions,
            'recentContacts' => $recentContacts,
            'userAccounts' => $cuentas // ✅ ESTO ES LO QUE TU VISTA NECESITA
        ]);
    }

    /* ===========================
       PROCESO DE TRANSFERENCIA
       =========================== */

    public function store(Request $request)
{
    $request->validate([
        'account' => 'required|string',
        'amount' => 'required|numeric|min:1',
        'source_account' => 'required|string|in:principal,ahorros',
        'description' => 'nullable|string|max:100',
    ]);

    $monto = floatval($request->amount);
    $source = $request->source_account;

    // Inicializar saldos
    if (!session()->has('saldo_real')) session(['saldo_real' => 5000.00]);
    if (!session()->has('saldo_ahorros')) session(['saldo_ahorros' => 15250.75]);

    $saldo_real = session('saldo_real');
    $saldo_ahorros = session('saldo_ahorros');

    // ✅ VALIDACIÓN SERIA: no permitir saldos negativos
    if ($source === 'ahorros' && $monto > $saldo_ahorros) {
        return back()->withErrors(['amount' => 'Saldo insuficiente en Ahorros Personales.']);
    }

    if ($source === 'principal' && $monto > $saldo_real) {
        return back()->withErrors(['amount' => 'Saldo insuficiente en Saldo Principal.']);
    }

    // ✅ DESCUENTO CONTROLADO
    if ($source === 'ahorros') {
        session(['saldo_ahorros' => $saldo_ahorros - $monto]);
        $accountName = 'Ahorros Personales';
    } else {
        session(['saldo_real' => $saldo_real - $monto]);
        $accountName = 'Saldo Principal';
    }

    // ✅ REGISTRAR MOVIMIENTO
    $transactions = session('transactions', []);
    $transactions[] = [
        'description' => $request->description ?: 'Transferencia a ' . $request->account,
        'date' => date('Y-m-d H:i'),
        'amount' => -$monto,
        'type' => 'debit',
        'account' => $accountName,
    ];

    session(['transactions' => $transactions]);

    return redirect()->route('transactions.transfer')
        ->with('success', 'Transferencia realizada correctamente desde ' . $accountName);
}
}
