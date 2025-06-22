<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\detail_order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders with status filtering.
     */
    public function index(Request $request)
    {
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
                      $customerQuery->where('customer_name', 'like', "%{$search}%");
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
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customer,customer_id',
            'payment_id' => 'required|exists:payment,payment_id',
            'order_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product,product_id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.item_quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->route('orders.create')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Generate order ID
            $order_id = 'ORD' . str_pad(mt_rand(0, 99999), 5, '0', STR_PAD_LEFT);

            // Create order with default status
            $orderData = [
                'order_id' => $order_id,
                'customer_id' => $request->input('customer_id'),
                'payment_id' => $request->input('payment_id'),
                'order_date' => $request->input('order_date'),
                'total_price' => $request->input('total_price'),
                'subtotal' => $request->input('subtotal'),
                'tax_amount' => $request->input('tax_amount', 0),
                'status' => 'UNPAID' // Default status
            ];

            $order = Order::create($orderData);

            // Create order details
            foreach ($request->input('products') as $productData) {
                $detail_id = 'DTL' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                
                detail_order::create([
                    'detail_id' => $detail_id,
                    'order_id' => $order_id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'item_quantity' => $productData['item_quantity']
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
            'total_price' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'tax_amount' => 'nullable|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
            'status_info' => 'nullable|string|max:500',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product,product_id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.item_quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->route('orders.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $order = Order::where('order_id', $id)->firstOrFail();

            // Update order data
            $orderData = [
                'customer_id' => $request->input('customer_id'),
                'payment_id' => $request->input('payment_id'),
                'total_price' => $request->input('total_price'),
                'order_date' => $request->input('order_date'),
                'tax_amount' => $request->input('tax_amount', 0),
                'subtotal' => $request->input('subtotal'),
                'status' => $request->input('status'),
                'status_info' => $request->input('status_info')
            ];

            $order->update($orderData);

            // Delete existing order details
            detail_order::where('order_id', $id)->delete();

            // Create new order details
            foreach ($request->input('products') as $productData) {
                $detail_id = 'DTL' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
                
                detail_order::create([
                    'detail_id' => $detail_id,
                    'order_id' => $id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'item_quantity' => $productData['item_quantity']
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
            if ($request->has('status_info') && $request->status_info !== '') {
                $order->status_info = $request->status_info;
            }
            
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui',
                'order' => [
                    'order_id' => $order->order_id,
                    'status' => $order->status,
                    'status_label' => $order->status_label,
                    'status_info' => $order->status_info
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
            $updated = Order::whereIn('order_id', $request->order_ids)
                           ->update([
                               'status' => $request->status,
                               'updated_at' => now()
                           ]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil memperbarui {$updated} pesanan",
                'updated_count' => $updated
            ]);

        } catch (\Exception $e) {
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
            
            // Delete order details first
            detail_order::where('order_id', $id)->delete();
            
            // Delete the order
            $order->delete();
            
            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
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
                $product = Product::where('product_id', $productData['product_id'])->first();
                if ($product) {
                    $subtotal += $product->price * $productData['quantity'];
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
     * Get orders for frontend display (API endpoint)
     */
    public function getOrdersForFrontend(Request $request)
    {
        try {
            $query = Order::with(['customer', 'detailOrders.product']);

            // Filter by status if provided
            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', strtoupper($request->status));
            }

            // Filter by customer if authenticated (implement based on your auth system)
            // if (auth()->check()) {
            //     $query->where('customer_id', auth()->user()->customer_id);
            // }

            $orders = $query->orderBy('order_date', 'desc')->get();

            $formattedOrders = $orders->map(function($order) {
                // Get first product details for display
                $firstDetail = $order->detailOrders->first();
                $product = $firstDetail ? $firstDetail->product : null;

                return [
                    'order_id' => $order->order_id,
                    'merchant' => $product ? $product->merchant_name ?? 'RecycleX Store' : 'RecycleX Store',
                    'name' => $product ? $product->product_name : 'Mixed Products',
                    'description1' => $product ? $product->description : 'Multiple items in this order',
                    'description2' => "Total items: {$order->detailOrders->sum('quantity')}",
                    'image' => $product && $product->image ? asset('storage/' . $product->image) : asset('Assets/default-product.png'),
                    'price' => 'Rp ' . number_format($order->subtotal, 0, ',', '.'),
                    'total' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                    'status' => $order->status,
                    'statusInfo' => $order->status_info,
                    'order_date' => $order->order_date->format('d/m/Y H:i')
                ];
            });

            return response()->json([
                'success' => true,
                'orders' => $formattedOrders
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order statistics for dashboard
     */
    public function getOrderStatistics()
    {
        try {
            $stats = [
                'total_orders' => Order::count(),
                'unpaid_orders' => Order::where('status', 'UNPAID')->count(),
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