<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Coins</title>
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
        .coin-total {
            font-weight: bold;
            color: #f39c12;
        }
        .coin-earned {
            color: #27ae60;
        }
        .coins-icon {
            color: #f39c12;
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
                <h3 class="card-title">
                    <i class="fas fa-coins coins-icon me-2"></i>
                    Kelola Coins
                </h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCoinsModal">
                    <i class="fas fa-plus"></i> Tambah Coins
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Coins</th>
                            <th>Total Coins</th>
                            <th>Coins Earned</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coins as $index => $coin)
                        <tr>
                            <td>{{ $coins->firstItem() + $index }}</td>
                            <td>{{ $coin->coins_id }}</td>
                            <td class="coin-total">
                                <i class="fas fa-coins me-1"></i>
                                {{ number_format($coin->coins_total, 0, ',', '.') }}
                            </td>
                            <td class="coin-earned">
                                <i class="fas fa-plus-circle me-1"></i>
                                {{ number_format($coin->coins_earned, 0, ',', '.') }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('coins.show', $coin->coins_id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('coins.edit', $coin->coins_id) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn"
                                            title="Hapus"
                                            data-id="{{ $coin->coins_id }}"
                                            data-total="{{ $coin->coins_total }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data coins</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $coins->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- tambahin ini -->
    <x-footer.footer/>

    <!-- Add Coins Modal -->
    <div class="modal fade" id="addCoinsModal" tabindex="-1" aria-labelledby="addCoinsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCoinsModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tambah Coins Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('coins.store') }}" method="POST" id="addCoinsForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coins_total" class="form-label">
                                        <i class="fas fa-coins coins-icon me-1"></i>
                                        Total Coins <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" id="coins_total" name="coins_total" min="0" required>
                                </div>
                               
                                <div class="mb-3">
                                    <label for="coins_earned" class="form-label">
                                        <i class="fas fa-plus-circle coin-earned me-1"></i>
                                        Coins Earned
                                    </label>
                                    <input type="number" class="form-control" id="coins_earned" name="coins_earned" min="0">
                                </div>
                            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>
                            Simpan
                        </button>
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
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus coins dengan ID <strong id="delete-coins-id"></strong>?</p>
                    <p>Total Coins: <strong class="coin-total" id="delete-coins-total"></strong></p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Tindakan ini tidak dapat dibatalkan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete coins
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const coinsId = this.getAttribute('data-id');
                    const coinsTotal = this.getAttribute('data-total');
                    const deleteForm = document.getElementById('deleteForm');
                    const deleteCoinsId = document.getElementById('delete-coins-id');
                    const deleteCoinsTotal = document.getElementById('delete-coins-total');
                   
                    // Set coins info in confirmation modal
                    deleteCoinsId.textContent = coinsId;
                    deleteCoinsTotal.textContent = new Intl.NumberFormat('id-ID').format(coinsTotal);
                   
                    // Set form action
                    deleteForm.action = '{{ url("coins") }}/' + coinsId;
                   
                    // Show modal
                    deleteModal.show();
                });
            });
        });
    </script>
</body>
</html>