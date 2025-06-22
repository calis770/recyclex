<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Seller - {{ $seller->shop_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Detail Seller</h3>
                <div class="btn-group" role="group">
                    <a href="{{ route('sellers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('sellers.edit', $seller->seller_id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Informasi Seller -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user"></i> Informasi Seller
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="40%">ID Seller:</td>
                                        <td>{{ $seller->seller_id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Username:</td>
                                        <td>{{ $seller->username_seller }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Nama Lengkap:</td>
                                        <td>{{ $seller->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email:</td>
                                        <td>
                                            <a href="mailto:{{ $seller->email }}" class="text-decoration-none">
                                                {{ $seller->email }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">No. Telepon:</td>
                                        <td>
                                            <a href="tel:{{ $seller->seller_phone_number }}" class="text-decoration-none">
                                                {{ $seller->seller_phone_number }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Alamat:</td>
                                        <td>{{ $seller->seller_address }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Toko -->
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-store"></i> Informasi Toko
                                </h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold" width="40%">Nama Toko:</td>
                                        <td>
                                            <span class="badge bg-info fs-6">{{ $seller->shop_name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Jenis Bisnis:</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">{{ $seller->business_type }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Deskripsi Toko:</td>
                                        <td>
                                            @if($seller->shop_description)
                                                <p class="mb-0">{{ $seller->shop_description }}</p>
                                            @else
                                                <em class="text-muted">Tidak ada deskripsi</em>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Aksi</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('sellers.edit', $seller->seller_id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit Seller
                                    </a>
                                    <button type="button" class="btn btn-info" onclick="copySellerInfo()">
                                        <i class="fas fa-copy"></i> Salin Info
                                    </button>
                                    <form action="{{ route('sellers.destroy', $seller->seller_id) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus seller ini? Tindakan ini tidak dapat dibatalkan!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Hapus Seller
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function copySellerInfo() {
            const sellerInfo = `
ID Seller: {{ $seller->seller_id }}
Username: {{ $seller->username_seller }}
Nama Lengkap: {{ $seller->full_name }}
Email: {{ $seller->email }}
No. Telepon: {{ $seller->seller_phone_number }}
Alamat: {{ $seller->seller_address }}
Nama Toko: {{ $seller->shop_name }}
Jenis Bisnis: {{ $seller->business_type }}
Deskripsi: {{ $seller->shop_description ?? 'Tidak ada deskripsi' }}
            `.trim();
            
            navigator.clipboard.writeText(sellerInfo).then(function() {
                // Create toast notification
                const toast = document.createElement('div');
                toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
                toast.setAttribute('role', 'alert');
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-check-circle me-2"></i>
                            Informasi seller berhasil disalin!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                
                document.body.appendChild(toast);
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();
                
                // Remove toast after it's hidden
                toast.addEventListener('hidden.bs.toast', function() {
                    document.body.removeChild(toast);
                });
            }).catch(function(err) {
                alert('Gagal menyalin informasi: ' + err);
            });
        }
    </script>
</body>
</html>