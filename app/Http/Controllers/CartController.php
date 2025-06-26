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
     * Updated to handle both regular form submission and AJAX requests
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:product,product_id',
            'quantity' => 'required|integer|min:1',
            'variation' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 400);
            }
            
            return redirect()->route('carts.create')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Generate cart ID
            $cart_id = 'CT' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Get product to calculate total price
            $product = Product::where('product_id', $request->input('product_id'))->first();
            $quantity = $request->input('quantity');
            $total_price = $product->price * $quantity;

            // Check if item with same product and variation already exists
            $existingCart = Cart::where('product_id', $request->input('product_id'))
                ->where('variation', $request->input('variation', ''))
                ->first();

            if ($existingCart) {
                // Update existing cart item
                $newQuantity = $existingCart->quantity + $quantity;
                $newTotalPrice = $product->price * $newQuantity;
                
                $existingCart->update([
                    'quantity' => $newQuantity,
                    'total_price' => $newTotalPrice
                ]);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item quantity updated in cart',
                        'cart_item' => $existingCart
                    ]);
                }
            } else {
                // Create new cart item
                $cartData = [
                    'id_cart' => $cart_id,
                    'product_id' => $request->input('product_id'),
                    'quantity' => $quantity,
                    'variation' => $request->input('variation', ''),
                    'total_price' => $total_price
                ];

                $cartItem = Cart::create($cartData);

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item added to cart successfully',
                        'cart_item' => $cartItem
                    ]);
                }
            }

            return redirect()->route('carts.index')
                ->with('success', 'Item berhasil ditambahkan ke keranjang.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add item to cart: ' . $e->getMessage()
                ], 500);
            }
            
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
            'variation' => 'nullable|string'
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
                'variation' => $request->input('variation', ''),
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
     * Get cart item details for AJAX request
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

    /**
     * Get cart count for badge display
     */
    public function getCartCount()
    {
        try {
            $cartItems = Cart::all();
            $totalItems = $cartItems->sum('quantity');
            
            return response()->json([
                'success' => true,
                'cart_count' => $totalItems
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil jumlah item keranjang'
            ], 500);
        }
    }

    /**
     * Add item to cart via AJAX (alternative method)
     */
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:product,product_id',
            'quantity' => 'required|integer|min:1',
            'variation' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            DB::beginTransaction();

            $product = Product::where('product_id', $request->input('product_id'))->first();
            $quantity = $request->input('quantity');
            $variation = $request->input('variation', '');

            // Check if item already exists in cart
            $existingCart = Cart::where('product_id', $request->input('product_id'))
                ->where('variation', $variation)
                ->first();

            if ($existingCart) {
                // Update existing item
                $newQuantity = $existingCart->quantity + $quantity;
                $newTotalPrice = $product->price * $newQuantity;
                
                $existingCart->update([
                    'quantity' => $newQuantity,
                    'total_price' => $newTotalPrice
                ]);

                $cartItem = $existingCart;
            } else {
                // Create new cart item
                $cart_id = 'CT' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                
                $cartItem = Cart::create([
                    'id_cart' => $cart_id,
                    'product_id' => $request->input('product_id'),
                    'quantity' => $quantity,
                    'variation' => $variation,
                    'total_price' => $product->price * $quantity
                ]);
            }

            // Get updated cart count
            $totalCartItems = Cart::sum('quantity');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang',
                'cart_item' => $cartItem->load('product'),
                'cart_count' => $totalCartItems
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan item ke keranjang: ' . $e->getMessage()
            ], 500);
        }
    }
}