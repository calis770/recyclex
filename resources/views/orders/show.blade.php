<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pesanan - {{ $order->order_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .status-badge {
            font-size: 1rem;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
        }
        .status-UNPAID { background-color: #ffc107; color: #000; }
        .status-PACKED { background-color: #17a2b8; color: #fff; }
        .status-SENT { background-color: #6f42c1; color: #fff; }
        .status-DONE { background-color: #28a745; color: #fff; }
        .status-CANCELLED { background-color: #dc3545; color: #fff; }
        
        .info-card {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .product-image {
            max-width: 80px;
            max-height: 80px;
            object-fit: cover;
        }
        
        .detail-row {
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 0;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .total-section {
            background-color: #e9ecef;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        .btn-group .btn {
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
        }
    </style>
</head>
<body>
    <!-- navbar -->
    <x-header.navbar/>
    <div class="container-fluid">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h2>Detail Pesanan</h2>
            <div class="btn-group">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('orders.edit', $order->order_id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="btn btn-success" id="statusBtn" 
                        data-id="{{ $order->order_id }}" 
                        data-status="{{ $order->status }}">
                    <i class="fas fa-sync"></i> Update Status
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Order Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-receipt"></i> Informasi Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <strong>ID Pesanan:</strong> {{ $order->order_id }}
                        </div>
                        <div class="detail-row">
                            <strong>Tanggal Pesanan:</strong> {{ $order->order_date->format('d/m/Y H:i:s') }}
                        </div>
                        <div class="detail-row">
                            <strong>Status:</strong> 
                            <span class="status-badge status-{{ $order->status }}">
                                {{ $order->status_label ?? $order->status }}
                            </span>
                        </div>
                        @if($order->status_info)
                        <div class="detail-row">
                            <strong>Keterangan Status:</strong><br>
                            <span class="text-muted">{{ $order->status_info }}</span>
                        </div>
                        @endif
                        <div class="detail-row">
                            <strong>Metode Pembayaran:</strong> {{ $order->payment->payment_method ?? 'N/A' }}
                        </div>
                        @if($order->payment && $order->payment->description)
                        <div class="detail-row">
                            <strong>Deskripsi Pembayaran:</strong> {{ $order->payment->description }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-user"></i> Informasi Customer</h5>
                    </div>
                    <div class="card-body">
                        @if($order->customer)
                        <div class="detail-row">
                            <strong>Nama:</strong> {{ $order->customer->customer_name }}
                        </div>
                        <div class="detail-row">
                            <strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Telepon:</strong> {{ $order->customer->phone ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Alamat:</strong> {{ $order->customer->address ?? 'N/A' }}
                        </div>
                        @else
                        <div class="text-muted">Data customer tidak tersedia</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details/Products -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-shopping-cart"></i> Detail Produk</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Item Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->detailOrders as $detail)
                            <tr>
                                <td>
                                    @if($detail->product && $detail->product->image_product)
                                        <img src="{{ asset('storage/' . $detail->product->image_product) }}"
                                             alt="{{ $detail->product->product_name }}"
                                             class="img-thumbnail product-image">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $detail->product->product_name ?? 'Produk tidak ditemukan' }}</strong>
                                    @if($detail->product && $detail->product->variasi)
                                        <br><small class="text-muted">{{ $detail->product->variasi }}</small>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->item_quantity }}</td>
                                <td>Rp {{ number_format(($detail->product->price ?? 0) * $detail->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Order Summary -->
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <div class="total-section">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if($order->tax_amount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Pajak:</span>
                                <span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer.footer/>

    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Status Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusForm">
                    @csrf
                    <div class="modal-body">
                        <p>Update status untuk pesanan <strong>{{ $order->order_id }}</strong></p>
                        <div class="mb-3">
                            <label for="new_status" class="form-label">Status Baru</label>
                            <select class="form-select" id="new_status" name="status" required>
                                <option value="UNPAID" {{ $order->status == 'UNPAID' ? 'selected' : '' }}>Belum Dibayar</option>
                                <option value="PACKED" {{ $order->status == 'PACKED' ? 'selected' : '' }}>Dikemas</option>
                                <option value="SENT" {{ $order->status == 'SENT' ? 'selected' : '' }}>Dikirim</option>
                                <option value="DONE" {{ $order->status == 'DONE' ? 'selected' : '' }}>Selesai</option>
                                <option value="CANCELLED" {{ $order->status == 'CANCELLED' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status_info" class="form-label">Keterangan Status (Opsional)</label>
                            <textarea class="form-control" id="status_info" name="status_info" rows="3" 
                                      placeholder="Tambahkan keterangan untuk status ini...">{{ $order->status_info }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Status update
            const statusBtn = document.getElementById('statusBtn');
            const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
            const statusForm = document.getElementById('statusForm');

            if (statusBtn) {
                statusBtn.addEventListener('click', function() {
                    const orderId = this.getAttribute('data-id');
                    
                    statusForm.onsubmit = function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(statusForm);
                        
                        fetch(`{{ url('orders') }}/${orderId}/status`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: formData.get('status'),
                                status_info: formData.get('status_info')
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Gagal mengupdate status: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat mengupdate status');
                        });
                    };
                    
                    statusModal.show();
                });
            }
        });
    </script>
</body>
</html>