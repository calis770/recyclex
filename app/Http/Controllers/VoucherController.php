<?php

namespace App\Http\Controllers;

use App\Models\voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class VoucherController extends Controller
{
    /**
     * Display a listing of the vouchers.
     */
    public function index()
    {
        $vouchers = voucher::paginate(10);
        return view('vouchers.index', compact('vouchers'));
    }

    /**
     * Store a newly created voucher in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => 'required|numeric|min:0|max:100',
            'expiration_date' => 'required|date|after_or_equal:today',
        ]);
   
        if ($validator->fails()) {
            return redirect()->route('vouchers.index')
                ->withErrors($validator)
                ->withInput();
        }
   
        $voucher_id = 'V' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
   
        $voucherData = [
            'voucher_id' => $voucher_id,
            'discount' => $request->input('discount'),
            'expiration_date' => $request->input('expiration_date'),
        ];
   
        voucher::create($voucherData);
   
        return redirect()->route('vouchers.index')
            ->with('success', 'Voucher berhasil ditambahkan.');
    }
   
    /**
     * Display the specified voucher.
     */
    public function show(string $id)
    {
        try {
            $voucher = voucher::where('voucher_id', $id)->firstOrFail();
            return view('vouchers.show', compact('voucher'));
        } catch (\Exception $e) {
            return redirect()->route('vouchers.index')
                ->with('error', 'Voucher tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified voucher.
     */
    public function edit(string $id)
    {
        try {
            $voucher = voucher::where('voucher_id', $id)->firstOrFail();
            return view('vouchers.edit', compact('voucher'));
        } catch (\Exception $e) {
            return redirect()->route('vouchers.index')
                ->with('error', 'Voucher tidak ditemukan.');
        }
    }

    /**
     * Update the specified voucher in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $voucher = voucher::where('voucher_id', $id)->firstOrFail();
       
            $validator = Validator::make($request->all(), [
                'discount' => 'required|numeric|min:0|max:100',
                'expiration_date' => 'required|date|after_or_equal:today',
            ]);
       
            if ($validator->fails()) {
                return redirect()->route('vouchers.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
       
            $voucherData = [
                'discount' => $request->input('discount'),
                'expiration_date' => $request->input('expiration_date'),
            ];
       
            $voucher->update($voucherData);
       
            return redirect()->route('vouchers.index')
                ->with('success', 'Voucher berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('vouchers.index')
                ->with('error', 'Gagal memperbarui voucher: ' . $e->getMessage());
        }
    }
   
    /**
     * Remove the specified voucher from storage.
     */
    public function destroy(string $id)
    {
        try {
            $voucher = voucher::where('voucher_id', $id)->firstOrFail();
            $voucher->delete();
    
            return redirect()->route('vouchers.index')
                ->with('success', 'Voucher berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('vouchers.index')
                ->with('error', 'Gagal menghapus voucher: ' . $e->getMessage());
        }
    }
}