<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Transactions extends Controller
{
    public function loans()
    {
        return view('transactions.loans');
    }

    public function qr()
    {
        return view('transactions.qr-payments');
    }

    public function transfer()
    {
        // Inicializar saldo y movimientos si no existen en sesión
        if (!session()->has('saldo_real')) {
            session([
                'saldo_real' => 5000.00, // saldo inicial
                'transactions' => [
                    [
                        'description' => 'Depósito Nómina',
                        'date' => date('Y-m-d'),
                        'amount' => 5000.00,
                        'type' => 'credit',
                    ],
                ],
            ]);
        }

        $saldo = session('saldo_real');
        $transactions = session('transactions');

        // Ejemplo de contactos recientes
        $recentContacts = [
            ['name' => 'Juan Pérez', 'account' => '1234567890'],
            ['name' => 'María López', 'account' => '0987654321'],
            ['name' => 'Carlos García', 'account' => '1122334455'],
        ];

        return view('transactions.transfers', compact('recentContacts', 'saldo', 'transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $saldo = session('saldo_real');
        $monto = $request->amount;

        // Validar saldo suficiente
        if ($monto > $saldo) {
            return back()->withErrors(['amount' => 'No tienes saldo suficiente para realizar esta transferencia.']);
        }

        // Restar monto del saldo real
        $saldo -= $monto;
        session(['saldo_real' => $saldo]);

        // Agregar la transferencia a movimientos
        $transactions = session('transactions');
        $transactions[] = [
            'description' => $request->description ?: 'Transferencia a ' . $request->account,
            'date' => date('Y-m-d'),
            'amount' => -$monto,
            'type' => 'debit',
        ];
        session(['transactions' => $transactions]);

        return redirect()->route('transactions.transfer')
            ->with('success', 'Transferencia realizada correctamente.');
    }
}
