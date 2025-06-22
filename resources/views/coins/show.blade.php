<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Coins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .coin-total {
            font-weight: bold;
            color: #f39c12;
            font-size: 1.5rem;
        }
        .coin-earned {
            color: #27ae60;
            font-size: 1.2rem;
        }
        .coins-icon {
            color: #f39c12;
        }
        .detail-card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        .history-box {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card detail-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-coins me-2"></i>
                            Detail Coins
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="detail-label">ID Coins:</label>
                                    <div class="mt-1">
                                        <span class="badge bg-secondary fs-6">{{ $coin->coins_id }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="detail-label">
                                        <i class="fas fa-coins coins-icon me-1"></i>
                                        Total Coins:
                                    </label>
                                    <div class="coin-total mt-1">
                                        {{ number_format($coin->coins_total, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="detail-label">
                                        <i class="fas fa-plus-circle coin-earned me-1"></i>
                                        Coins Earned:
                                    </label>
                                    <div class="coin-earned mt-1">
                                        {{ number_format($coin->coins_earned, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="detail-label">
                                    <i class="fas fa-history me-1"></i>
                                    Riwayat Coins:
                                </label>
                                <div class="history-box mt-2">
                                    @if($coin->coins_history)
                                        {{ $coin->coins_history }}
                                    @else
                                        <em class="text-muted">Tidak ada riwayat yang tercatat</em>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong> Data coins ini menampilkan total coins dan coins yang diperoleh beserta riwayat transaksinya.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('coins.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali
                            </a>
                            <div>
                                <a href="{{ route('coins.edit', $coin->coins_id) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-1"></i>
                                    Edit
                                </a>
                                <button class="btn btn-danger delete-btn"
                                        data-id="{{ $coin->coins_id }}"
                                        data-total="{{ $coin->coins_total }}">
                                    <i class="fas fa-trash me-1"></i>
                                    Hapus
                                </button>
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
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus coins dengan ID <strong>{{ $coin->coins_id }}</strong>?</p>
                    <p>Total Coins: <strong class="coin-total">{{ number_format($coin->coins_total, 0, ',', '.') }}</strong></p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-circle me-1"></i>
                        Tindakan ini tidak dapat dibatalkan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('coins.destroy', $coin->coins_id) }}" method="POST">
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
            const deleteButton = document.querySelector('.delete-btn');
            if (deleteButton) {
                const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                
                deleteButton.addEventListener('click', function() {
                    deleteModal.show();
                });
            }
        });
    </script>
</body>
</html>