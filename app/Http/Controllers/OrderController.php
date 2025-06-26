<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DetailOrder; // Changed from detail_order
use App\Models\Product;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import Str facade for Str::limit

class OrderController extends Controller
{
    /**
     * Display a listing of the orders with status filtering.
     */
    public function index(Request $request)
    {
        // Use `customer` instead of `Customer` if your relationship name is `customer` in Order model
        $query = Order::with(['customer', 'payment']);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function($customerQuery) use ($search) {
                        $customerQuery->where('customer_name', 'like', "%{$search}%"); // Assuming customer_name in customer table
                    });
            });
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(10);
        $statusOptions = Order::getStatusOptions();

        return view('orders.index', compact('orders', 'statusOptions'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $products = Product::all();
        $customers = Customer::all();
        $payments = Payment::all();
        
        return view('orders.create', compact('products', 'customers', 'payments'));
    }

    /**
     * Store a newly created order in storage.
     * This method would typically be used by the admin to create manual orders.
     * For customer orders, a different process (e.g., from a cart) would populate the DB.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customer,customer_id',
            'payment_id' => 'required|exists:payment,payment_id',
            'order_date' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product,product_id',
            'products.*.quantity' => 'required|integer|min:1',
            // 'products.*.item_quantity' => 'required|integer|min:1' // item_quantity seems redundant if quantity already exists
        ]);

        if ($validator->fails()) {
            return redirect()->route('orders.create')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Generate order ID
            $order_id = 'ORD' . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT); // Simple incrementing ID

            $total_price = 0;
            $subtotal = 0;
            $tax_rate = 0.1; // 10% tax

            foreach ($request->input('products') as $productData) {
                $product = Product::where('product_id', $productData['product_id'])->first();
                if (!$product) {
                    throw new \Exception("Product with ID {$productData['product_id']} not found.");
                }
                $subtotal += $product->price * $productData['quantity'];
            }
            $tax_amount = $subtotal * $tax_rate;
            $total_price = $subtotal + $tax_amount;

            // Create order with default status
            $orderData = [
                'order_id' => $order_id,
                'customer_id' => $request->input('customer_id'),
                'payment_id' => $request->input('payment_id'),
                'order_date' => $request->input('order_date'),
                'total_price' => $total_price,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'status' => 'UNPAID', // Default status for new orders
                'status_info' => 'Menunggu pembayaran dari pelanggan'
            ];

            $order = Order::create($orderData);

            // Create order details
            foreach ($request->input('products') as $productData) {
                $detail_id = 'DTL' . str_pad(DetailOrder::count() + 1, 6, '0', STR_PAD_LEFT); // Simple incrementing ID
                $product = Product::where('product_id', $productData['product_id'])->first(); // Fetch product again for its price

                DetailOrder::create([
                    'detail_id' => $detail_id,
                    'order_id' => $order_id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'price_at_order' => $product->price, // Store the price at the time of order
                ]);
            }

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('orders.create')
                ->with('error', 'Gagal menambahkan pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        try {
            $order = Order::with(['customer', 'payment', 'detailOrders.product'])
                ->where('order_id', $id)
                ->firstOrFail();
            
            return view('orders.show', compact('order'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(string $id)
    {
        try {
            $order = Order::with(['detailOrders.product'])
                ->where('order_id', $id)
                ->firstOrFail();
            
            $customers = Customer::all();
            $products = Product::all();
            $payments = Payment::all();
            $statusOptions = Order::getStatusOptions();
            
            return view('orders.edit', compact('order', 'customers', 'products', 'payments', 'statusOptions'));
        } catch (\Exception $e) {
            return redirect()->route('orders.index')
                ->with('error', 'Pesanan tidak ditemukan.');
        }
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customer,customer_id',
            'payment_id' => 'required|exists:payment,payment_id',
            'order_date' => 'required|date',
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
            'status_info' => 'nullable|string|max:500',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product,product_id',
            'products.*.quantity' => 'required|integer|min:1',
            // 'products.*.item_quantity' => 'required|integer|min:1' // Redundant field removed
        ]);

        if ($validator->fails()) {
            return redirect()->route('orders.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $order = Order::where('order_id', $id)->firstOrFail();

            $total_price = 0;
            $subtotal = 0;
            $tax_rate = 0.1; // 10% tax

            foreach ($request->input('products') as $productData) {
                $product = Product::where('product_id', $productData['product_id'])->first();
                if (!$product) {
                    throw new \Exception("Product with ID {$productData['product_id']} not found.");
                }
                $subtotal += $product->price * $productData['quantity'];
            }
            $tax_amount = $subtotal * $tax_rate;
            $total_price = $subtotal + $tax_amount;


            // Update order data
            $orderData = [
                'customer_id' => $request->input('customer_id'),
                'payment_id' => $request->input('payment_id'),
                'total_price' => $total_price,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'order_date' => $request->input('order_date'),
                'status' => $request->input('status'),
                'status_info' => $request->input('status_info')
            ];

            $order->update($orderData);

            // Delete existing order details
            DetailOrder::where('order_id', $id)->delete(); // Changed from detail_order

            // Create new order details
            foreach ($request->input('products') as $productData) {
                $detail_id = 'DTL' . str_pad(DetailOrder::count() + 1, 6, '0', STR_PAD_LEFT); // Simple incrementing ID for new details
                $product = Product::where('product_id', $productData['product_id'])->first(); // Fetch product again for its price

                DetailOrder::create([ // Changed from detail_order
                    'detail_id' => $detail_id,
                    'order_id' => $id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'price_at_order' => $product->price, // Store the price at the time of order
                ]);
            }

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('orders.index')
                ->with('error', 'Gagal memperbarui pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Update only the order status (AJAX endpoint for quick status updates)
     */
    public function updateStatus(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
            'status_info' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::where('order_id', $id)->firstOrFail();
            
            $order->status = $request->status;
            // Only update status_info if it's provided and not empty
            if ($request->filled('status_info')) {
                $order->status_info = $request->status_info;
            } else {
                // If status_info is empty, set it to the default based on new status
                $order->status_info = $order->getStatusInfoAttribute(null); // Pass null to get default
            }
            
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui',
                'order' => [
                    'order_id' => $order->order_id,
                    'status' => $order->status,
                    'status_label' => $order->status_label,
                    'status_info' => $order->status_info // Return the actual (potentially default) status_info
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan atau terjadi kesalahan: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Bulk update order statuses
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,order_id',
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updated = 0;
            DB::beginTransaction();
            foreach ($request->order_ids as $orderId) {
                $order = Order::where('order_id', $orderId)->first();
                if ($order) {
                    $order->status = $request->status;
                    $order->status_info = $order->getStatusInfoAttribute(null); // Set default info for bulk
                    $order->save();
                    $updated++;
                }
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil memperbarui {$updated} pesanan",
                'updated_count' => $updated
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $order = Order::where('order_id', $id)->firstOrFail();
            
            // Delete associated detail orders first to respect foreign key constraints
            $order->detailOrders()->delete(); // Using relationship to delete
            
            // Delete the order
            $order->delete();
            
            DB::commit();

            // Check if request expects JSON (for AJAX)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dihapus.'
                ]);
            }

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            
            // Check if request expects JSON (for AJAX)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus pesanan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('orders.index')
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Get order details for AJAX request
     */
    public function getOrderDetails(string $id)
    {
        try {
            $order = Order::with(['detailOrders.product', 'customer', 'payment'])
                ->where('order_id', $id)
                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Calculate total price based on selected products (for AJAX)
     */
    public function calculateTotal(Request $request)
    {
        try {
            $products = $request->input('products', []);
            $subtotal = 0;
            
            foreach ($products as $productData) {
                // Ensure product_id and quantity are present and valid
                if (!isset($productData['product_id']) || !isset($productData['quantity'])) {
                    throw new \Exception("Invalid product data provided.");
                }
                $product = Product::where('product_id', $productData['product_id'])->first();
                if ($product) {
                    $subtotal += $product->price * $productData['quantity'];
                } else {
                    // Optionally, handle cases where product is not found
                    throw new \Exception("Product with ID {$productData['product_id']} not found for calculation.");
                }
            }
            
            $tax_rate = 0.1; // 10% tax
            $tax_amount = $subtotal * $tax_rate;
            $total_price = $subtotal + $tax_amount;
            
            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'tax_amount' => $tax_amount,
                'total_price' => $total_price
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung total: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get orders for frontend display (API endpoint for all customers - NOT RECOMMENDED for customer's My Order)
     */
    // public function getOrdersForFrontend(Request $request) // DEPRECATED for customer's view
    // {
    //     // This method would show ALL orders. For customer's "My Order", use CustomerOrderController.
    //     // Kept for reference but won't be used by the customer frontend.
    // }

    /**
     * Get order statistics for dashboard
     */
    public function getOrderStatistics()
    {
        try {
            $stats = [
                'total_orders' => Order::count(),
                'packed_orders' => Order::where('status', 'PACKED')->count(),
                'sent_orders' => Order::where('status', 'SENT')->count(),
                'completed_orders' => Order::where('status', 'DONE')->count(),
                'cancelled_orders' => Order::where('status', 'CANCELLED')->count(),
                'today_orders' => Order::whereDate('order_date', today())->count(),
                'total_revenue' => Order::where('status', 'DONE')->sum('total_price')
            ];

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}
