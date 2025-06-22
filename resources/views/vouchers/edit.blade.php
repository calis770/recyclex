<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Voucher - {{ $voucher->voucher_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .voucher-preview {
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="fas fa-edit text-warning"></i> Edit Voucher</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Kelola Voucher</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('vouchers.show', $voucher->voucher_id) }}">{{ $voucher->voucher_id }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('vouchers.show', $voucher->voucher_id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

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
            <!-- Form Section -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-edit"></i> Form Edit Voucher</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('vouchers.update', $voucher->voucher_id) }}" method="POST" id="editVoucherForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-section">
                                <h6 class="fw-bold mb-3"><i class="fas fa-info-circle"></i> Informasi Voucher</h6>
                                
                                <div class="mb-3">
                                    <label for="voucher_id_display" class="form-label">ID Voucher</label>
                                    <input type="text" class="form-control" id="voucher_id_display" value="{{ $voucher->voucher_id }}" readonly>
                                    <div class="form-text">ID Voucher tidak dapat diubah</div>
                                </div>

                                <div class="mb-3">
                                    <label for="discount" class="form-label">Diskon (%) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="discount" name="discount" 
                                               value="{{ old('discount', $voucher->discount) }}" 
                                               min="0" max="100" step="0.01" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="form-text">Masukkan nilai diskon antara 0-100%</div>
                                    @error('discount')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="expiration_date" class="form-label">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="expiration_date" name="expiration_date" 
                                           value="{{ old('expiration_date', $voucher->expiration_date) }}" 
                                           min="{{ date('Y-m-d') }}" required>
                                    <div class="form-text">Pilih tanggal kadaluarsa voucher (tidak boleh kurang dari hari ini)</div>
                                    @error('expiration_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="alert alert-info">
                                    <i class="fas fa-lightbulb"></i>
                                    <strong>Tips:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Pastikan tanggal kadaluarsa tidak terlalu dekat untuk memberikan waktu yang cukup bagi pelanggan</li>
                                        <li>Persentase diskon yang terlalu tinggi dapat berdampak pada keuntungan</li>
                                        <li>Pertimbangkan strategi pemasaran saat menentukan nilai diskon</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('vouchers.show', $voucher->voucher_id) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Voucher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="col-md-4">
                <div class="card voucher-preview sticky-top" style="top: 20px;">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-ticket-alt fa-3x mb-3"></i>
                            <h4 class="card-title">{{ $voucher->voucher_id }}</h4>
                        </div>
                        <div class="mb-3">
                            <h1 class="display-4 fw-bold" id="discount-preview">{{ $voucher->discount }}%</h1>
                            <p class="lead">DISKON</p>
                        </div>
                        <div class="border-top pt-3">
                            <p class="mb-1">Berlaku sampai:</p>
                            <h6 id="expiration-preview">{{ \Carbon\Carbon::parse($voucher->expiration_date)->format('d F Y') }}</h6>
                        </div>
                        <div class="mt-3">
                            <div id="status-preview">
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
                                        <i class="fas fa-exclamation-triangle"></i> Akan Berakhir
                                    </span>
                                @else
                                    <span class="voucher-status active">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-chart-line"></i> Status Saat Ini</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            @php
                                $expirationDate = \Carbon\Carbon::parse($voucher->expiration_date);
                                $today = \Carbon\Carbon::now();
                                $daysUntilExpiration = $today->diffInDays($expirationDate, false);
                            @endphp
                            
                            @if($daysUntilExpiration < 0)
                                <div class="text-danger">
                                    <i class="fas fa-times-circle fa-2x mb-2"></i>
                                    <p class="fw-bold">Kadaluarsa</p>
                                    <small>{{ abs($daysUntilExpiration) }} hari yang lalu</small>
                                </div>
                            @elseif($daysUntilExpiration <= 7)
                                <div class="text-warning">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <p class="fw-bold">Akan Berakhir</p>
                                    <small>{{ $daysUntilExpiration }} hari lagi</small>
                                </div>
                            @else
                                <div class="text-success">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <p class="fw-bold">Aktif</p>
                                    <small>{{ $daysUntilExpiration }} hari lagi</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountInput = document.getElementById('discount');
            const expirationInput = document.getElementById('expiration_date');
            const discountPreview = document.getElementById('discount-preview');
            const expirationPreview = document.getElementById('expiration-preview');
            const statusPreview = document.getElementById('status-preview');

            // Update discount preview
            discountInput.addEventListener('input', function() {
                const value = this.value || '0';
                discountPreview.textContent = value + '%';
            });

            // Update expiration date preview
            expirationInput.addEventListener('change', function() {
                if (this.value) {
                    const date = new Date(this.value);
                    const options = { 
                        day: 'numeric', 
                        month: 'long', 
                        year: 'numeric' 
                    };
                    const formattedDate = date.toLocaleDateString('id-ID', options);
                    expirationPreview.textContent = formattedDate;

                    // Update status based on new date
                    const today = new Date();
                    const timeDiff = date.getTime() - today.getTime();
                    const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    let statusHtml = '';
                    if (daysDiff < 0) {
                        statusHtml = '<span class="voucher-status expired"><i class="fas fa-times-circle"></i> Kadaluarsa</span>';
                    } else if (daysDiff <= 7) {
                        statusHtml = '<span class="voucher-status expiring-soon"><i class="fas fa-exclamation-triangle"></i> Akan Berakhir</span>';
                    } else {
                        statusHtml = '<span class="voucher-status active"><i class="fas fa-check-circle"></i> Aktif</span>';
                    }
                    statusPreview.innerHTML = statusHtml;
                }
            });

            // Set minimum date for expiration date input
            const today = new Date().toISOString().split('T')[0];
            expirationInput.setAttribute('min', today);

            // Form validation
            const form = document.getElementById('editVoucherForm');
            form.addEventListener('submit', function(e) {
                const discount = parseFloat(discountInput.value);
                const expirationDate = new Date(expirationInput.value);
                const today = new Date();

                if (discount < 0 || discount > 100) {
                    e.preventDefault();
                    alert('Diskon harus antara 0-100%');
                    discountInput.focus();
                    return;
                }

                if (expirationDate <= today) {
                    e.preventDefault();
                    alert('Tanggal kadaluarsa harus lebih dari hari ini');
                    expirationInput.focus();
                    return;
                }
            });
        });
    </script>
</body>
</html>