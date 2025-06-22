<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Customer - {{ $customer->full_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .detail-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .detail-row {
            border-bottom: 1px solid #f0f0f0;
            padding: 1rem 0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .detail-value {
            color: #6c757d;
            font-size: 1.1rem;
        }
        .badge-status {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
        .btn-back {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.7rem 2rem;
            color: white;
            font-weight: 500;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }
        .btn-edit {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border: none;
            border-radius: 25px;
            padding: 0.7rem 2rem;
            color: #333;
            font-weight: 500;
        }
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #333;
        }
        .icon-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .customer-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #495057;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Header Section -->
        <div class="info-card">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <div class="customer-avatar">
                        {{ strtoupper(substr($customer->full_name, 0, 2)) }}
                    </div>
                </div>
                <div class="col-md-7">
                    <h2 class="mb-2">{{ $customer->full_name }}</h2>
                    <p class="mb-1"><i class="fas fa-user me-2"></i>{{ $customer->username_customer }}</p>
                    <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $customer->email }}</p>
                    <p class="mb-0"><i class="fas fa-id-card me-2"></i>{{ $customer->customer_id }}</p>
                </div>
                <div class="col-md-3 text-end">
                    <div class="icon-wrapper ms-auto">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </div>
                    <span class="badge bg-light text-dark badge-status">
                        <i class="fas fa-check-circle text-success me-1"></i>
                        Active Customer
                    </span>
                </div>
            </div>
        </div>

        <!-- Detail Information -->
        <div class="row">
            <div class="col-md-8">
                <div class="card detail-card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informasi Detail Customer
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-id-badge text-primary me-2"></i>Customer ID
                            </div>
                            <div class="detail-value">{{ $customer->customer_id }}</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-user text-success me-2"></i>Nama Lengkap
                            </div>
                            <div class="detail-value">{{ $customer->full_name }}</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-at text-info me-2"></i>Username
                            </div>
                            <div class="detail-value">{{ $customer->username_customer }}</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-envelope text-warning me-2"></i>Email
                            </div>
                            <div class="detail-value">{{ $customer->email }}</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-phone text-danger me-2"></i>No. Telepon
                            </div>
                            <div class="detail-value">{{ $customer->phone_number }}</div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-label">
                                <i class="fas fa-map-marker-alt text-secondary me-2"></i>Alamat
                            </div>
                            <div class="detail-value">
                                @if($customer->customer_address)
                                    {{ $customer->customer_address }}
                                @else
                                    <span class="text-muted font-style-italic">Alamat belum diisi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card detail-card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs text-primary me-2"></i>
                            Aksi Customer
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="d-grid gap-2">
                            <a href="{{ route('customers.edit', $customer->customer_id) }}" 
                               class="btn btn-edit">
                                <i class="fas fa-edit me-2"></i>Edit Customer
                            </a>
                            
                            <button class="btn btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>Hapus Customer
                            </button>
                            
                            <hr class="my-3">
                            
                            <a href="{{ route('customers.index') }}" 
                               class="btn btn-back">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Stats Card -->
                <div class="card detail-card mt-3">
                    <div class="card-header bg-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-line text-success me-2"></i>
                            Statistik Singkat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h5 class="text-primary mb-1">0</h5>
                                    <small class="text-muted">Total Order</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="text-success mb-1">Rp 0</h5>
                                <small class="text-muted">Total Pembelian</small>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Data akan diperbarui saat ada transaksi
                            </small>
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
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                        <p>Apakah Anda yakin ingin menghapus customer <strong>{{ $customer->full_name }}</strong>?</p>
                        <p class="text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Tindakan ini tidak dapat dibatalkan!
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>