<?php

namespace App\Http\Controllers;

use App\Models\shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    /**
     * Display a listing of the shippings.
     */
    public function index()
    {
        $shippings = shipping::paginate(10);
        return view('shippings.index', compact('shippings'));
    }

    /**
     * Store a newly created shipping in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_status' => 'required|string|max:255',
        ]);
   
        if ($validator->fails()) {
            return redirect()->route('shippings.index')
                ->withErrors($validator)
                ->withInput();
        }
   
        $shipping_id = 'S' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
   
        $shippingData = [
            'shipping_id' => $shipping_id,
            'shipping_status' => $request->input('shipping_status'),
        ];
   
        shipping::create($shippingData);
   
        return redirect()->route('shippings.index')
            ->with('success', 'Shipping berhasil ditambahkan.');
    }
   
    /**
     * Display the specified shipping.
     */
    public function show(string $id)
    {
        try {
            $shipping = shipping::where('shipping_id', $id)->firstOrFail();
            return view('shippings.show', compact('shipping'));
        } catch (\Exception $e) {
            return redirect()->route('shippings.index')
                ->with('error', 'Shipping tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified shipping.
     */
    public function edit(string $id)
    {
        try {
            $shipping = shipping::where('shipping_id', $id)->firstOrFail();
            return view('shippings.edit', compact('shipping'));
        } catch (\Exception $e) {
            return redirect()->route('shippings.index')
                ->with('error', 'Shipping tidak ditemukan.');
        }
    }

    /**
     * Update the specified shipping in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $shipping = shipping::where('shipping_id', $id)->firstOrFail();
       
            $validator = Validator::make($request->all(), [
                'shipping_status' => 'required|string|max:255',
            ]);
       
            if ($validator->fails()) {
                return redirect()->route('shippings.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
       
            $shippingData = [
                'shipping_status' => $request->input('shipping_status'),
            ];
       
            $shipping->update($shippingData);
       
            return redirect()->route('shippings.index')
                ->with('success', 'Shipping berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('shippings.index')
                ->with('error', 'Gagal memperbarui shipping: ' . $e->getMessage());
        }
    }
   
    /**
     * Remove the specified shipping from storage.
     */
    public function destroy(string $id)
    {
        try {
            $shipping = shipping::where('shipping_id', $id)->firstOrFail();
            $shipping->delete();
    
            return redirect()->route('shippings.index')
                ->with('success', 'Shipping berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('shippings.index')
                ->with('error', 'Gagal menghapus shipping: ' . $e->getMessage());
        }
    }
}