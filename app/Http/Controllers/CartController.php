<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items.
     */
    public function index()
    {
        $carts = Cart::with('product')->orderBy('id_cart', 'desc')->paginate(10);
        return view('carts.index', compact('carts'));
    }

    /**
     * Show the form for creating a new cart item.
     */
    public function create()
    {
        $products = Product::all();
        
        return view('carts.create', compact('products'));
    }

    /**
     * Store a newly created cart item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:product,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('carts.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generate cart ID
            $cart_id = 'CT' . str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);

            // Get product to calculate total price
            $product = Product::where('product_id', $request->input('product_id'))->first();
            $total_price = $product->price * $request->input('quantity');

            // Create cart item
            $cartData = [
                'id_cart' => $cart_id,
                'product_id' => $request->input('product_id'),
                'quantity' => $request->input('quantity'),
                'total_price' => $total_price
            ];

            Cart::create($cartData);

            return redirect()->route('carts.index')
                ->with('success', 'Item berhasil ditambahkan ke keranjang.');

        } catch (\Exception $e) {
            return redirect()->route('carts.create')
                ->with('error', 'Gagal menambahkan item ke keranjang: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified cart item.
     */
    public function show(string $id)
    {
        try {
            $cart = Cart::with('product')
                ->where('id_cart', $id)
                ->firstOrFail();
            
            return view('carts.show', compact('cart'));
        } catch (\Exception $e) {
            return redirect()->route('carts.index')
                ->with('error', 'Item keranjang tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified cart item.
     */
    public function edit(string $id)
    {
        try {
            $cart = Cart::with('product')
                ->where('id_cart', $id)
                ->firstOrFail();
            
            $products = Product::all();
            
            return view('carts.edit', compact('cart', 'products'));
        } catch (\Exception $e) {
            return redirect()->route('carts.index')
                ->with('error', 'Item keranjang tidak ditemukan.');
        }
    }

    /**
     * Update the specified cart item in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:product,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('carts.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $cart = Cart::where('id_cart', $id)->firstOrFail();

            // Get product to calculate total price
            $product = Product::where('product_id', $request->input('product_id'))->first();
            $total_price = $product->price * $request->input('quantity');

            // Update cart item data
            $cartData = [
                'product_id' => $request->input('product_id'),
                'quantity' => $request->input('quantity'),
                'total_price' => $total_price
            ];

            $cart->update($cartData);

            return redirect()->route('carts.index')
                ->with('success', 'Item keranjang berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->route('carts.index')
                ->with('error', 'Gagal memperbarui item keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified cart item from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cart = Cart::where('id_cart', $id)->firstOrFail();
            
            // Delete the cart item
            $cart->delete();

            return redirect()->route('carts.index')
                ->with('success', 'Item keranjang berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()->route('carts.index')
                ->with('error', 'Gagal menghapus item keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Get cart item details for AJAX request (optional)
     */
    public function getCartDetails(string $id)
    {
        try {
            $cart = Cart::with('product')
                ->where('id_cart', $id)
                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $cart
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Item keranjang tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Calculate total price for cart items
     */
    public function calculateCartTotal()
    {
        try {
            $cartItems = Cart::with('product')->get();
            $totalPrice = $cartItems->sum('total_price');
            $totalQuantity = $cartItems->sum('quantity');
            
            return response()->json([
                'success' => true,
                'total_price' => $totalPrice,
                'total_quantity' => $totalQuantity,
                'items_count' => $cartItems->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung total keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear all cart items
     */
    public function clearCart()
    {
        try {
            Cart::truncate();
            
            return redirect()->route('carts.index')
                ->with('success', 'Keranjang berhasil dikosongkan.');
        } catch (\Exception $e) {
            return redirect()->route('carts.index')
                ->with('error', 'Gagal mengosongkan keranjang: ' . $e->getMessage());
        }
    }

    /**
     * Update quantity of cart item via AJAX
     */
    public function updateQuantity(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity harus berupa angka positif.'
            ], 400);
        }

        try {
            $cart = Cart::with('product')->where('id_cart', $id)->firstOrFail();
            $newQuantity = $request->input('quantity');
            $newTotalPrice = $cart->product->price * $newQuantity;

            $cart->update([
                'quantity' => $newQuantity,
                'total_price' => $newTotalPrice
            ]);

            return response()->json([
                'success' => true,
                'new_total_price' => $newTotalPrice,
                'formatted_price' => 'Rp ' . number_format($newTotalPrice, 0, ',', '.')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui quantity: ' . $e->getMessage()
            ], 500);
        }
    }
}
