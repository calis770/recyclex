<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Voucher - {{ $voucher->voucher_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .voucher-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .voucher-status {
            font-weight: bold;
        }
        .expired {
            color: #dc3545;
        }
        .active {
            color: #198754;
        }
        .expiring-soon {
            color: #ffc107;
        }
        .info-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .info-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 1.1em;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="fas fa-ticket-alt text-primary"></i> Detail Voucher</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Kelola Voucher</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $voucher->voucher_id }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('vouchers.edit', $voucher->voucher_id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Voucher Card -->
            <div class="col-md-6 mb-4">
                <div class="card voucher-card">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-ticket-alt fa-3x mb-3"></i>
                            <h3 class="card-title">{{ $voucher->voucher_id }}</h3>
                        </div>
                        <div class="mb-3">
                            <h1 class="display-3 fw-bold">{{ $voucher->discount }}%</h1>
                            <p class="lead">DISKON</p>
                        </div>
                        <div class="border-top pt-3">
                            <p class="mb-1">Berlaku sampai:</p>
                            <h5>{{ \Carbon\Carbon::parse($voucher->expiration_date)->format('d F Y') }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Voucher Information -->
            <div class="col-md-6 mb-4">
                <div class="card info-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Voucher</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="info-item">
                            <div class="info-label">ID Voucher</div>
                            <div class="info-value">{{ $voucher->voucher_id }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Persentase Diskon</div>
                            <div class="info-value">{{ $voucher->discount }}%</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tanggal Kadaluarsa</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($voucher->expiration_date)->format('d F Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                @php
                                    $expirationDate = \Carbon\Carbon::parse($voucher->expiration_date);
                                    $today = \Carbon\Carbon::now();
                                    $daysUntilExpiration = $today->diffInDays($expirationDate, false);
                                @endphp
                                
                                @if($daysUntilExpiration < 0)
                                    <span class="voucher-status expired">
                                        <i class="fas fa-times-circle"></i> Kadaluarsa
                                    </span>
                                @elseif($daysUntilExpiration <= 7)
                                    <span class="voucher-status expiring-soon">
                                        <i class="fas fa-exclamation-triangle"></i> Akan Berakhir dalam {{ $daysUntilExpiration }} hari
                                    </span>
                                @else
                                    <span class="voucher-status active">
                                        <i class="fas fa-check-circle"></i> Aktif ({{ $daysUntilExpiration }} hari lagi)
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Sisa Waktu</div>
                            <div class="info-value">
                                @if($daysUntilExpiration < 0)
                                    <span class="text-danger">Sudah berakhir {{ abs($daysUntilExpiration) }} hari yang lalu</span>
                                @else
                                    <span class="text-success">{{ $daysUntilExpiration }} hari lagi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="row">
            <div class="col-12">
                <div class="card info-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-line"></i> Statistik & Informasi Tambahan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <div class="p-3">
                                    <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                                    <h6>Tanggal Dibuat</h6>
                                    <p class="text-muted">
                                        @if(isset($voucher->created_at))
                                            {{ \Carbon\Carbon::parse($voucher->created_at)->format('d F Y') }}
                                        @else
                                            <span class="text-muted">Tidak tersedia</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3">
                                    <i class="fas fa-percentage fa-2x text-success mb-2"></i>
                                    <h6>Nilai Diskon</h6>
                                    <p class="text-success fw-bold">{{ $voucher->discount }}%</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="p-3">
                                    <i class="fas fa-hourglass-half fa-2x text-warning mb-2"></i>
                                    <h6>Durasi Berlaku</h6>
                                    <p class="text-muted">
                                        @if(isset($voucher->created_at))
                                            {{ \Carbon\Carbon::parse($voucher->created_at)->diffInDays(\Carbon\Carbon::parse($voucher->expiration_date)) }} hari
                                        @else
                                            <span class="text-muted">Tidak tersedia</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('vouchers.index') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-list"></i> Lihat Semua Voucher
                </a>
                <a href="{{ route('vouchers.edit', $voucher->voucher_id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Edit Voucher
                </a>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash"></i> Hapus Voucher
                </button>
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
                    <p>Apakah Anda yakin ingin menghapus voucher <strong>{{ $voucher->voucher_id }}</strong> dengan diskon <strong>{{ $voucher->discount }}%</strong>?</p>
                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('vouchers.destroy', $voucher->voucher_id) }}" method="POST" style="display: inline;">
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