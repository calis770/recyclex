<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shipping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .edit-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .form-label {
            font-weight: 600;
            color: #374151;
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-shipped {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-delivered {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card edit-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-edit text-warning me-2"></i>
                            Edit Shipping
                        </h3>
                        <a href="{{ route('shippings.index') }}" 
                           class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('shippings.update', $shipping->shipping_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <!-- Current Status Display -->
                                    <div class="mb-4">
                                        <label class="form-label">Status Saat Ini:</label>
                                        <div>
                                            @php
                                                $statusClass = 'status-badge ';
                                                $status = strtolower($shipping->shipping_status);
                                                
                                                if (str_contains($status, 'pending') || str_contains($status, 'menunggu')) {
                                                    $statusClass .= 'status-pending';
                                                } elseif (str_contains($status, 'processing') || str_contains($status, 'proses')) {
                                                    $statusClass .= 'status-processing';
                                                } elseif (str_contains($status, 'shipped') || str_contains($status, 'dikirim')) {
                                                    $statusClass .= 'status-shipped';
                                                } elseif (str_contains($status, 'delivered') || str_contains($status, 'terkirim')) {
                                                    $statusClass .= 'status-delivered';
                                                } elseif (str_contains($status, 'cancelled') || str_contains($status, 'dibatalkan')) {
                                                    $statusClass .= 'status-cancelled';
                                                } else {
                                                    $statusClass .= 'status-pending';
                                                }
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ $shipping->shipping_status }}</span>
                                        </div>
                                    </div>

                                    <!-- Shipping ID Display -->
                                    <div class="mb-3">
                                        <label class="form-label">ID Shipping:</label>
                                        <input type="text" class="form-control" value="{{ $shipping->shipping_id }}" readonly disabled>
                                    </div>

                                    <!-- New Status Selection -->
                                    <div class="mb-3">
                                        <label for="shipping_status" class="form-label">Status Shipping Baru <span class="text-danger">*</span></label>
                                        <select class="form-select" id="shipping_status" name="shipping_status" required>
                                            <option value="">Pilih Status Shipping</option>
                                            <option value="Pending" {{ old('shipping_status', $shipping->shipping_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Processing" {{ old('shipping_status', $shipping->shipping_status) == 'Processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="Shipped" {{ old('shipping_status', $shipping->shipping_status) == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="Delivered" {{ old('shipping_status', $shipping->shipping_status) == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="Cancelled" {{ old('shipping_status', $shipping->shipping_status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            <option value="Menunggu Konfirmasi" {{ old('shipping_status', $shipping->shipping_status) == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                            <option value="Sedang Diproses" {{ old('shipping_status', $shipping->shipping_status) == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                            <option value="Dalam Pengiriman" {{ old('shipping_status', $shipping->shipping_status) == 'Dalam Pengiriman' ? 'selected' : '' }}>Dalam Pengiriman</option>
                                            <option value="Telah Diterima" {{ old('shipping_status', $shipping->shipping_status) == 'Telah Diterima' ? 'selected' : '' }}>Telah Diterima</option>
                                            <option value="Dibatalkan" {{ old('shipping_status', $shipping->shipping_status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                        <div class="form-text">Atau Anda bisa mengetik status custom:</div>
                                        <input type="text" 
                                               class="form-control mt-2" 
                                               id="custom_status" 
                                               name="custom_status" 
                                               placeholder="Status custom (opsional)"
                                               value="{{ old('custom_status') }}">
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="text-center mt-4">
                                        <div class="btn-group" role="group">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Simpan Perubahan
                                            </button>
                                            <a href="{{ route('shippings.show', $shipping->shipping_id) }}" 
                                               class="btn btn-info">
                                                <i class="fas fa-eye"></i> Lihat Detail
                                            </a>
                                            <a href="{{ route('shippings.index') }}" 
                                               class="btn btn-secondary">
                                                <i class="fas fa-times"></i> Batal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle custom status input
            const statusSelect = document.getElementById('shipping_status');
            const customStatusInput = document.getElementById('custom_status');
            
            customStatusInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    statusSelect.value = '';
                    statusSelect.removeAttribute('required');
                    this.setAttribute('required', '');
                    this.setAttribute('name', 'shipping_status');
                } else {
                    statusSelect.setAttribute('required', '');
                    this.removeAttribute('required');
                    this.removeAttribute('name');
                }
            });

            statusSelect.addEventListener('change', function() {
                if (this.value !== '') {
                    customStatusInput.value = '';
                    customStatusInput.removeAttribute('required');
                    customStatusInput.removeAttribute('name');
                    this.setAttribute('required', '');
                }
            });
        });
    </script>
</body>
</html>