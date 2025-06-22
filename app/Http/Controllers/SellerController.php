<?php

namespace App\Http\Controllers;

use App\Models\seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    /**
     * Display a listing of the sellers.
     */
    public function index()
    {
        $sellers = seller::orderBy('full_name', 'asc')->paginate(10);
        return view('sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new seller.
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created seller in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username_seller' => 'required|string|max:50|unique:seller,username_seller',
            'seller_phone_number' => 'required|string|max:15',
            'seller_address' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:seller,email',
            'full_name' => 'required|string|max:100',
            'shop_name' => 'required|string|max:100',
            'business_type' => 'required|string|max:50',
            'shop_description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->route('sellers.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generate seller ID
            $seller_id = 'S' . str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);

            // Create seller
            $sellerData = [
                'seller_id' => $seller_id,
                'username_seller' => $request->input('username_seller'),
                'seller_phone_number' => $request->input('seller_phone_number'),
                'seller_address' => $request->input('seller_address'),
                'email' => $request->input('email'),
                'full_name' => $request->input('full_name'),
                'shop_name' => $request->input('shop_name'),
                'business_type' => $request->input('business_type'),
                'shop_description' => $request->input('shop_description')
            ];

            seller::create($sellerData);

            return redirect()->route('sellers.index')
                ->with('success', 'Seller berhasil ditambahkan.');

        } catch (\Exception $e) {
            return redirect()->route('sellers.create')
                ->with('error', 'Gagal menambahkan seller: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified seller.
     */
    public function show(string $id)
    {
        try {
            $seller = seller::where('seller_id', $id)->firstOrFail();
            
            return view('sellers.show', compact('seller'));
        } catch (\Exception $e) {
            return redirect()->route('sellers.index')
                ->with('error', 'Seller tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified seller.
     */
    public function edit(string $id)
    {
        try {
            $seller = seller::where('seller_id', $id)->firstOrFail();
            
            return view('sellers.edit', compact('seller'));
        } catch (\Exception $e) {
            return redirect()->route('sellers.index')
                ->with('error', 'Seller tidak ditemukan.');
        }
    }

    /**
     * Update the specified seller in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'username_seller' => 'required|string|max:50|unique:seller,username_seller,' . $id . ',seller_id',
            'seller_phone_number' => 'required|string|max:15',
            'seller_address' => 'required|string|max:255',
            'email' => 'required|email|max:100|unique:seller,email,' . $id . ',seller_id',
            'full_name' => 'required|string|max:100',
            'shop_name' => 'required|string|max:100',
            'business_type' => 'required|string|max:50',
            'shop_description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->route('sellers.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $seller = seller::where('seller_id', $id)->firstOrFail();

            // Update seller data
            $sellerData = [
                'username_seller' => $request->input('username_seller'),
                'seller_phone_number' => $request->input('seller_phone_number'),
                'seller_address' => $request->input('seller_address'),
                'email' => $request->input('email'),
                'full_name' => $request->input('full_name'),
                'shop_name' => $request->input('shop_name'),
                'business_type' => $request->input('business_type'),
                'shop_description' => $request->input('shop_description')
            ];

            $seller->update($sellerData);

            return redirect()->route('sellers.index')
                ->with('success', 'Seller berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->route('sellers.index')
                ->with('error', 'Gagal memperbarui seller: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified seller from storage.
     */
    public function destroy(string $id)
    {
        try {
            $seller = seller::where('seller_id', $id)->firstOrFail();
            
            // Delete the seller
            $seller->delete();

            return redirect()->route('sellers.index')
                ->with('success', 'Seller berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('sellers.index')
                ->with('error', 'Gagal menghapus seller: ' . $e->getMessage());
        }
    }

    /**
     * Get seller details for AJAX request (optional)
     */
    public function getSellerDetails(string $id)
    {
        try {
            $seller = seller::where('seller_id', $id)->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $seller
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Seller tidak ditemukan.'
            ], 404);
        }
    }
}