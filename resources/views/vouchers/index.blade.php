<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Voucher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.1rem;
        }
        .modal-lg {
            max-width: 800px;
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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Kelola Voucher</h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addVoucherModal">
                    <i class="fas fa-plus"></i> Tambah Voucher
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Voucher</th>
                            <th>Diskon (%)</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $index => $voucher)
                        <tr>
                            <td>{{ $vouchers->firstItem() + $index }}</td>
                            <td>{{ $voucher->voucher_id }}</td>
                            <td>{{ $voucher->discount }}%</td>
                            <td>{{ \Carbon\Carbon::parse($voucher->expiration_date)->format('d/m/Y') }}</td>
                            <td>
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
                                        <i class="fas fa-exclamation-triangle"></i> Akan Berakhir ({{ $daysUntilExpiration }} hari)
                                    </span>
                                @else
                                    <span class="voucher-status active">
                                        <i class="fas fa-check-circle"></i> Aktif ({{ $daysUntilExpiration }} hari)
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('vouchers.show', $voucher->voucher_id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('vouchers.edit', $voucher->voucher_id) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn"
                                            title="Hapus"
                                            data-id="{{ $voucher->voucher_id }}"
                                            data-discount="{{ $voucher->discount }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data voucher</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- tambahin ini -->
    <x-footer.footer/>
    <!-- Add Voucher Modal -->
    <div class="modal fade" id="addVoucherModal" tabindex="-1" aria-labelledby="addVoucherModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVoucherModalLabel">Tambah Voucher Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('vouchers.store') }}" method="POST" id="addVoucherForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Diskon (%) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="0.01" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="form-text">Masukkan nilai diskon antara 0-100%</div>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expiration_date" class="form-label">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="expiration_date" name="expiration_date" min="{{ date('Y-m-d') }}" required>
                                    <div class="form-text">Pilih tanggal kadaluarsa voucher</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Informasi:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>ID Voucher akan dibuat otomatis dengan format V0001, V0002, dst.</li>
                                        <li>Diskon maksimal adalah 100%</li>
                                        <li>Tanggal kadaluarsa tidak boleh kurang dari hari ini</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
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
                    <p>Apakah Anda yakin ingin menghapus voucher dengan diskon <strong id="delete-voucher-discount"></strong>?</p>
                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete voucher
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const voucherId = this.getAttribute('data-id');
                    const voucherDiscount = this.getAttribute('data-discount');
                    const deleteForm = document.getElementById('deleteForm');
                    const deleteVoucherDiscount = document.getElementById('delete-voucher-discount');
                   
                    // Set voucher discount in confirmation modal
                    deleteVoucherDiscount.textContent = voucherDiscount + '%';
                   
                    // Set form action
                    deleteForm.action = '{{ url("vouchers") }}/' + voucherId;
                   
                    // Show modal
                    deleteModal.show();
                });
            });

            // Set minimum date for expiration date input
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('expiration_date').setAttribute('min', today);
        });
    </script>
</body>
</html>