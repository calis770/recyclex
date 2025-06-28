<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders with status filtering.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('nama_penerima', 'like', "%{$search}%")
                  ->orWhere('merchant_name', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%");
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
        $statusOptions = Order::getStatusOptions();
        return view('orders.create', compact('statusOptions'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_date' => 'required|date',
            'total_price' => 'required|integer|min:0',
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
            'merchant_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|integer|min:0',
            'status_info' => 'nullable|string|max:500',
            'nama_penerima' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'alamat_penerima' => 'required|string|max:500',
            'kota_penerima' => 'required|string|max:100',
            'kode_pos_penerima' => 'required|string|max:10',
            'provinsi' => 'required|string|max:100',
            'note_pengiriman' => 'nullable|string|max:500',
            'payment_method' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Silakan periksa input Anda.');
        }

        DB::beginTransaction();
        
        try {
            // Generate unique order ID
            $orderId = $this->generateOrderId();

            // Calculate total_price from unit_price and quantity if not provided
            $totalPrice = $request->total_price ?: ($request->unit_price * $request->quantity);

            // Create order
            $order = Order::create([
                'order_id' => $orderId,
                'order_date' => $request->order_date,
                'total_price' => $totalPrice,
                'status' => $request->status,
                'merchant_name' => $request->merchant_name,
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                'product_image' => $request->product_image,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'status_info' => $request->status_info,
                'nama_penerima' => $request->nama_penerima,
                'nomor_hp' => $request->nomor_hp,
                'alamat_penerima' => $request->alamat_penerima,
                'kota_penerima' => $request->kota_penerima,
                'kode_pos_penerima' => $request->kode_pos_penerima,
                'provinsi' => $request->provinsi,
                'note_pengiriman' => $request->note_pengiriman,
                'payment_method' => $request->payment_method,
            ]);

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', "Pesanan #{$orderId} berhasil dibuat.");

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'order' => $order,
                    'status_label' => $order->status_label,
                    'full_address' => $order->full_address,
                    'formatted_total' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                    'formatted_unit_price' => 'Rp ' . number_format($order->unit_price, 0, ',', '.'),
                    'formatted_date' => Carbon::parse($order->order_date)->format('d/m/Y H:i'),
                ]
            ]);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $statusOptions = Order::getStatusOptions();

        return view('orders.edit', compact('order', 'statusOptions'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // If this is a status update request (AJAX)
        if ($request->expectsJson() && $request->has('status')) {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
                'status_info' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid.',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                $order->update([
                    'status' => $request->status,
                    'status_info' => $request->status_info,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => "Status pesanan #{$order->order_id} berhasil diupdate menjadi " . Order::getStatusOptions()[$request->status],
                    'data' => [
                        'order_id' => $order->order_id,
                        'status' => $order->status,
                        'status_label' => $order->status_label,
                        'status_info' => $order->status_info,
                    ]
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate status: ' . $e->getMessage()
                ], 500);
            }
        }

        // Full order update
        $validator = Validator::make($request->all(), [
            'order_date' => 'required|date',
            'total_price' => 'required|integer|min:0',
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
            'merchant_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_image' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|integer|min:0',
            'status_info' => 'nullable|string|max:500',
            'nama_penerima' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'alamat_penerima' => 'required|string|max:500',
            'kota_penerima' => 'required|string|max:100',
            'kode_pos_penerima' => 'required|string|max:10',
            'provinsi' => 'required|string|max:100',
            'note_pengiriman' => 'nullable|string|max:500',
            'payment_method' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Silakan periksa input Anda.');
        }

        DB::beginTransaction();
        
        try {
            // Calculate total_price from unit_price and quantity if not provided
            $totalPrice = $request->total_price ?: ($request->unit_price * $request->quantity);

            // Update order
            $order->update([
                'order_date' => $request->order_date,
                'total_price' => $totalPrice,
                'status' => $request->status,
                'merchant_name' => $request->merchant_name,
                'product_name' => $request->product_name,
                'product_description' => $request->product_description,
                'product_image' => $request->product_image,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'status_info' => $request->status_info,
                'nama_penerima' => $request->nama_penerima,
                'nomor_hp' => $request->nomor_hp,
                'alamat_penerima' => $request->alamat_penerima,
                'kota_penerima' => $request->kota_penerima,
                'kode_pos_penerima' => $request->kode_pos_penerima,
                'provinsi' => $request->provinsi,
                'note_pengiriman' => $request->note_pengiriman,
                'payment_method' => $request->payment_method,
            ]);

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', "Pesanan #{$order->order_id} berhasil diupdate.");

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        try {
            $orderId = $order->order_id;
            $order->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Pesanan #{$orderId} berhasil dihapus."
                ]);
            }

            return redirect()->route('orders.index')
                ->with('success', "Pesanan #{$orderId} berhasil dihapus.");

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus pesanan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update order status.
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'required|exists:orders,order_id',
            'status' => 'required|in:UNPAID,PACKED,SENT,DONE,CANCELLED',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $updatedCount = Order::whereIn('order_id', $request->order_ids)
                ->update([
                    'status' => $request->status,
                    'status_info' => "Status diupdate secara bulk ke " . Order::getStatusOptions()[$request->status],
                    'updated_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'message' => "{$updatedCount} pesanan berhasil diupdate ke status " . Order::getStatusOptions()[$request->status],
                'data' => [
                    'updated_count' => $updatedCount,
                    'status' => $request->status,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan bulk update: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate unique order ID.
     */
    private function generateOrderId()
    {
        $lastOrder = Order::orderBy('order_id', 'desc')->first();

        if (!$lastOrder || !preg_match('/^OD\d{3}$/', $lastOrder->order_id)) {
            return 'OD001';
        }

        $lastNumber = (int) substr($lastOrder->order_id, 2);
        $newNumber = $lastNumber + 1;

        return 'OD' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get order details for AJAX requests.
     */
    public function getOrderDetails($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'order_id' => $order->order_id,
                    'merchant_name' => $order->merchant_name ?? 'N/A',
                    'product_name' => $order->product_name ?? 'N/A',
                    'product_description' => $order->product_description ?? 'N/A',
                    'product_image' => $order->product_image,
                    'quantity' => $order->quantity,
                    'unit_price' => $order->unit_price,
                    'nama_penerima' => $order->nama_penerima ?? 'N/A',
                    'nomor_hp' => $order->nomor_hp ?? 'N/A',
                    'alamat_penerima' => $order->alamat_penerima ?? 'N/A',
                    'kota_penerima' => $order->kota_penerima ?? 'N/A',
                    'kode_pos_penerima' => $order->kode_pos_penerima ?? 'N/A',
                    'provinsi' => $order->provinsi ?? 'N/A',
                    'note_pengiriman' => $order->note_pengiriman,
                    'payment_method' => $order->payment_method ?? 'N/A',
                    'order_date' => Carbon::parse($order->order_date)->format('d/m/Y H:i'),
                    'status' => $order->status,
                    'status_label' => $order->status_label,
                    'status_info' => $order->status_info,
                    'total_price' => $order->total_price,
                    'formatted_unit_price' => 'Rp ' . number_format($order->unit_price, 0, ',', '.'),
                    'formatted_total' => 'Rp ' . number_format($order->total_price, 0, ',', '.'),
                    'full_address' => $order->full_address,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
}