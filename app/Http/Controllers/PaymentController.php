<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Assuming you have a Product model

class PaymentController extends Controller
{
    // Method yang sudah ada
    public function showPaymentPage(Request $request)
    {
        // Retrieve data sent from the product detail page
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $variationId = $request->input('variation_id');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $imageProduct = $request->input('image_product');

        // Fetch the product from the database using product_id
        $product = Product::where('product_id', $productId)->first();

        // If product is not found, redirect back with an error
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // You can also get the selected variation details if needed
        $selectedVariation = null;
        if ($variationId && $product->variations) {
            // Ensure $product->variations is an array, not a JSON string
            $variations = is_string($product->variations) ? json_decode($product->variations, true) : $product->variations;

            if (is_array($variations)) {
                foreach ($variations as $variation) {
                    if (isset($variation['id']) && $variation['id'] == $variationId) {
                        $selectedVariation = $variation;
                        break;
                    }
                }
            }
        }

        // Pass the data to your payment view
        return view('paymentpage', [ // Assuming 'payment.blade.php' is your payment page view
            'product' => $product,
            'quantity' => $quantity,
            'selectedVariation' => $selectedVariation,
            'totalPrice' => $productPrice * $quantity, // Calculate total price here
        ]);
    }

    // Method BARU untuk menangani checkout dari cart
    public function handleCartCheckout(Request $request)
    {
        // Validate that checkout data exists
        if (!$request->has('checkout_data')) {
            return redirect()->route('productcart')
                ->with('error', 'Data checkout tidak valid. Silakan coba lagi.');
        }

        try {
            // Decode checkout data dari cart
            $checkoutData = json_decode($request->input('checkout_data'), true);
            
            // Validate checkout data structure
            if (!isset($checkoutData['items']) || !is_array($checkoutData['items']) || empty($checkoutData['items'])) {
                return redirect()->route('productcart')
                    ->with('error', 'Tidak ada item yang dipilih untuk checkout.');
            }

            // Get product details for each item from database
            $cartItems = [];
            $subtotal = 0;

            foreach ($checkoutData['items'] as $item) {
                $product = Product::where('product_id', $item['product_id'])->first();
                
                if ($product) {
                    $itemTotal = $item['price'] * $item['quantity'];
                    $subtotal += $itemTotal;

                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'variant' => $item['variant'] ?? null,
                        'total' => $itemTotal,
                        'title' => $item['title'],
                        'image' => $item['image']
                    ];
                }
            }

            // Calculate shipping cost
            $shippingCost = $this->calculateShippingCost($cartItems);
            $totalPrice = $subtotal + $shippingCost;

            // Store data in session untuk payment processing
            session([
                'cart_checkout_data' => [
                    'items' => $cartItems,
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shippingCost,
                    'total' => $totalPrice,
                    'from_cart' => true
                ]
            ]);

            // Pass data to payment view
            return view('paymentpage', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'shippingCost' => $shippingCost,
                'totalPrice' => $totalPrice,
                'fromCart' => true
            ]);

        } catch (\Exception $e) {
            return redirect()->route('productcart')
                ->with('error', 'Terjadi kesalahan saat memproses checkout: ' . $e->getMessage());
        }
    }

    // Method untuk menghitung ongkos kirim
    private function calculateShippingCost($items)
    {
        // Logic sederhana untuk menghitung ongkir
        $baseShippingCost = 10000; // Rp 10,000 base cost
        $itemCount = count($items);
        
        // Tambah Rp 2,000 untuk setiap item tambahan
        $additionalCost = ($itemCount - 1) * 2000;
        
        return $baseShippingCost + $additionalCost;
    }

    // Method untuk memproses pembayaran
    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'shipping_address' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        try {
            // Get checkout data from session
            $checkoutData = session('cart_checkout_data');
            
            if (!$checkoutData) {
                return redirect()->route('productcart')
                    ->with('error', 'Data checkout tidak ditemukan. Silakan coba lagi.');
            }

            // Di sini Anda bisa menambahkan logic untuk:
            // 1. Membuat record order di database
            // 2. Memproses pembayaran dengan payment gateway
            // 3. Update stok produk
            // 4. Kirim email konfirmasi
            
            // Untuk sekarang, simulasi pembayaran berhasil
            $orderId = 'ORD' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Clear session data
            session()->forget('cart_checkout_data');
            
            return redirect()->route('order.success', ['order_id' => $orderId])
                ->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Method untuk halaman sukses order
    public function orderSuccess($orderId)
    {
        return view('order.success', compact('orderId'));
    }
}