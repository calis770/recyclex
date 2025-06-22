<?php

namespace App\Http\Controllers;

use App\Models\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $payments = payment::paginate(10);
        return view('payments.index', compact('payments'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet,crypto',
            'subtotal' => 'required|numeric|min:0',
        ]);
   
        if ($validator->fails()) {
            return redirect()->route('payments.index')
                ->withErrors($validator)
                ->withInput();
        }
   
        $payment_id = 'PAY' . str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
   
        $paymentData = [
            'payment_id' => $payment_id,
            'payment_method' => $request->input('payment_method'),
            'subtotal' => $request->input('subtotal'),
        ];
   
        payment::create($paymentData);
   
        return redirect()->route('payments.index')
            ->with('success', 'Payment berhasil ditambahkan.');
    }
   
    /**
     * Display the specified payment.
     */
    public function show(string $id)
    {
        try {
            $payment = payment::where('payment_id', $id)->firstOrFail();
            return view('payments.show', compact('payment'));
        } catch (\Exception $e) {
            return redirect()->route('payments.index')
                ->with('error', 'Payment tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit(string $id)
    {
        try {
            $payment = payment::where('payment_id', $id)->firstOrFail();
            return view('payments.edit', compact('payment'));
        } catch (\Exception $e) {
            return redirect()->route('payments.index')
                ->with('error', 'Payment tidak ditemukan.');
        }
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $payment = payment::where('payment_id', $id)->firstOrFail();
       
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required|in:cash,credit_card,debit_card,bank_transfer,e_wallet,crypto',
                'subtotal' => 'required|numeric|min:0',
            ]);
       
            if ($validator->fails()) {
                return redirect()->route('payments.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
       
            $paymentData = [
                'payment_method' => $request->input('payment_method'),
                'subtotal' => $request->input('subtotal'),
            ];
       
            $payment->update($paymentData);
       
            return redirect()->route('payments.index')
                ->with('success', 'Payment berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('payments.index')
                ->with('error', 'Gagal memperbarui payment: ' . $e->getMessage());
        }
    }
   
    /**
     * Remove the specified payment from storage.
     */
    public function destroy(string $id)
    {
        try {
            $payment = payment::where('payment_id', $id)->firstOrFail();
            $payment->delete();
    
            return redirect()->route('payments.index')
                ->with('success', 'Payment berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('payments.index')
                ->with('error', 'Gagal menghapus payment: ' . $e->getMessage());
        }
    }

    /**
     * Get payment method display name
     */
    private function getPaymentMethodName($method)
    {
        $methods = [
            'cash' => 'Tunai',
            'credit_card' => 'Kartu Kredit',
            'debit_card' => 'Kartu Debit',
            'bank_transfer' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'crypto' => 'Cryptocurrency'
        ];

        return $methods[$method] ?? $method;
    }
}
