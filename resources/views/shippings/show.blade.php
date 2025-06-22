<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Shipping</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .detail-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
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
        .detail-row {
            margin-bottom: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #374151;
        }
        .detail-value {
            color: #6b7280;
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

        <div class="row">
            <div class="col-12">
                <div class="card detail-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-shipping-fast text-primary me-2"></i>
                            Detail Shipping
                        </h3>
                        <div>
                            <a href="{{ route('shippings.edit', $shipping->shipping_id) }}" 
                               class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('shippings.index') }}" 
                               class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="detail-label">ID Shipping:</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="detail-value">{{ $shipping->shipping_id }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="detail-label">Status Shipping:</span>
                                        </div>
                                        <div class="col-sm-8">
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
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="detail-label">Dibuat:</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="detail-value">
                                                @if($shipping->created_at)
                                                    {{ \Carbon\Carbon::parse($shipping->created_at)->format('d M Y H:i:s') }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="detail-label">Terakhir Diperbarui:</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <span class="detail-value">
                                                @if($shipping->updated_at)
                                                    {{ \Carbon\Carbon::parse($shipping->updated_at)->format('d M Y H:i:s') }}
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('shippings.edit', $shipping->shipping_id) }}" 
                                   class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Status
                                </a>
                                <button class="btn btn-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                                <a href="{{ route('shippings.index') }}" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-list"></i> Daftar Shipping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus status shipping <strong>{{ $shipping->shipping_status }}</strong>?</p>
                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('shippings.destroy', $shipping->shipping_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>