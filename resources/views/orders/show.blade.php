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

        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
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
                            <strong>Tanggal Pesanan:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i:s') }}
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
                            <strong>Metode Pembayaran:</strong> {{ $order->payment_method ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Merchant:</strong> {{ $order->merchant_name ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-user"></i> Informasi Penerima</h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <strong>Nama Penerima:</strong> {{ $order->nama_penerima ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Nomor HP:</strong> {{ $order->nomor_hp ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Alamat:</strong> {{ $order->alamat_penerima ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Kota:</strong> {{ $order->kota_penerima ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Kode Pos:</strong> {{ $order->kode_pos_penerima ?? 'N/A' }}
                        </div>
                        <div class="detail-row">
                            <strong>Provinsi:</strong> {{ $order->provinsi ?? 'N/A' }}
                        </div>
                        @if($order->note_pengiriman)
                        <div class="detail-row">
                            <strong>Catatan Pengiriman:</strong><br>
                            <span class="text-muted">{{ $order->note_pengiriman }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-shopping-cart"></i> Detail Produk</h5>
            </div>
            <div class="card-body">
                <div class="product-card">
                    <div class="row">
                        <div class="col-md-2">
                            @if($order->product_image)
                                <img src="{{ $order->product_image }}"
                                     alt="{{ $order->product_name }}"
                                     class="img-thumbnail product-image w-100">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center product-image w-100">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-2">{{ $order->product_name ?? 'Produk tidak ditemukan' }}</h6>
                                    @if($order->product_description)
                                        <p class="text-muted mb-3">{{ $order->product_description }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <div class="col-6"><strong>Harga Satuan:</strong></div>
                                        <div class="col-6">Rp {{ number_format($order->unit_price ?? 0, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6"><strong>Jumlah:</strong></div>
                                        <div class="col-6">{{ $order->quantity ?? 0 }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6"><strong>Subtotal:</strong></div>
                                        <div class="col-6">Rp {{ number_format(($order->unit_price ?? 0) * ($order->quantity ?? 0), 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="row justify-content-end">
                    <div class="col-md-4">
                        <div class="total-section">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp {{ number_format(($order->unit_price ?? 0) * ($order->quantity ?? 0), 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong>Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</strong>
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
                                <option value="UNPAID" {{ $order->status == 'UNPAID' ? 'selected' : '' }}>Belum Bayar</option>
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
                        
                        fetch(`{{ url('orders') }}/${orderId}`, {
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
                                statusModal.hide();
                                
                                // Show success message
                                const alertDiv = document.createElement('div');
                                alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
                                alertDiv.innerHTML = `
                                    ${data.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                document.querySelector('.container-fluid').insertBefore(alertDiv, document.querySelector('.d-flex.justify-content-between'));
                                
                                // Update status badge
                                const statusBadge = document.querySelector('.status-badge');
                                statusBadge.className = `status-badge status-${data.data.status}`;
                                statusBadge.textContent = data.data.status_label;
                                
                                // Update status info if exists
                                const statusInfoElement = document.querySelector('.detail-row:has(.text-muted)');
                                if (data.data.status_info && statusInfoElement) {
                                    statusInfoElement.querySelector('.text-muted').textContent = data.data.status_info;
                                } else if (data.data.status_info) {
                                    // Create new status info row if doesn't exist
                                    const statusRow = document.querySelector('.status-badge').closest('.detail-row');
                                    const newRow = document.createElement('div');
                                    newRow.className = 'detail-row';
                                    newRow.innerHTML = `
                                        <strong>Keterangan Status:</strong><br>
                                        <span class="text-muted">${data.data.status_info}</span>
                                    `;
                                    statusRow.parentNode.insertBefore(newRow, statusRow.nextSibling);
                                }
                                
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