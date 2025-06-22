<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TransaksiOrder extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = Order::with('product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created order in storage
     */
    public function store(Request $request)
    {
        // Validation for shipping details and payment method
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'province' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'payment_method' => 'required|string|in:bank_transfer,credit_card,e_wallet_gopay,e_wallet_ovo,e_wallet_dana,cod',
            'cart_items' => 'required|array',
            'cart_items.*.product_id' => 'required|exists:products,id',
            'cart_items.*.quantity' => 'required|integer|min:1',
            'cart_items.*.price_per_item' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $customerAddress = sprintf(
                "%s, %s, %s, %s",
                $request->street_address,
                $request->city,
                $request->postal_code,
                $request->province
            );

            $orderCodes = []; // To store order codes if multiple orders are created

            foreach ($request->cart_items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // You might want to re-check stock here if your system tracks it per product
                // if ($product->stock < $item['quantity']) {
                //     DB::rollback();
                //     return response()->json(['message' => 'Stok produk ' . $product->name . ' tidak mencukupi'], 400);
                // }

                $orderCode = $this->generateOrderCode();
                $totalPrice = $item['price_per_item'] * $item['quantity'];

                $order = Order::create([
                    'order_code' => $orderCode,
                    'product_id' => $item['product_id'],
                    'customer_name' => $request->full_name,
                    // Assuming customer_email would come from authenticated user or separate input
                    'customer_email' => 'customer@example.com', // Placeholder, replace with actual email
                    'customer_phone' => $request->phone_number,
                    'customer_address' => $customerAddress,
                    'quantity' => $item['quantity'],
                    'price_per_item' => $item['price_per_item'],
                    'total_price' => $totalPrice,
                    'status' => 'UNPAID', // Initial status
                    'notes' => $request->notes,
                    'order_date' => now(),
                    'payment_method' => $request->payment_method, // Store selected payment method
                ]);
                $orderCodes[] = $order->order_code;

                // Update product stock if applicable
                // $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orders completed successfully!',
                'order_code' => implode(', ', $orderCodes), // Return all order codes
                'redirect_url' => route('order.success.page', ['order_codes' => $orderCodes]) // Example redirect
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load('product');
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order
     */
    public function edit(Order $order)
    {
        $products = Product::where('is_active', true)->get();
        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Update the specified order in storage
     */
    public function update(Request $request, Order $order)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
            'notes' => 'nullable|string|max:1000',
            'status_info' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Ambil data produk
            $product = Product::findOrFail($request->product_id);

            // Hitung ulang total harga jika quantity atau produk berubah
            $totalPrice = $product->price * $request->quantity;

            // Update order
            $order->update([
                'product_id' => $request->product_id,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'quantity' => $request->quantity,
                'price_per_item' => $product->price,
                'total_price' => $totalPrice,
                'status' => $request->status,
                'notes' => $request->notes,
                'status_info' => $request->status_info,
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Gagal mengupdate order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
            'status_info' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $order->update([
                'status' => $request->status,
                'status_info' => $request->status_info,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status order berhasil diupdate',
                'order' => $order->fresh()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified order from storage
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();

            return redirect()->route('orders.index')
                ->with('success', 'Order berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus order: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique order code
     */
    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }

    /**
     * Get order status options for select dropdown
     */
    public function getStatusOptions()
    {
        return response()->json(Order::getStatusOptions());
    }

    /**
     * Search orders by order code or customer name
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $orders = Order::with('product')
            ->where(function($q) use ($query) {
                $q->where('order_code', 'like', "%{$query}%")
                    ->orWhere('customer_name', 'like', "%{$query}%")
                    ->orWhere('customer_email', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json($orders);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Get orders by status
     */
    public function getByStatus($status)
    {
        $orders = Order::with('product')
            ->where('status', strtoupper($status))
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
    
    // Add a new method to handle the order success page redirect
    public function orderSuccess(Request $request)
    {
        $orderCodes = $request->query('order_codes', []);
        return view('orders.success', compact('orderCodes'));
    }
}