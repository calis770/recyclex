<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Coins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .coins-icon {
            color: #f39c12;
        }
        .coin-earned {
            color: #27ae60;
        }
        .edit-card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Flash Messages -->
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

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card edit-card">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Edit Coins
                        </h4>
                    </div>
                    <form action="{{ route('coins.update', $coin->coins_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">ID Coins:</label>
                                        <div class="mt-1">
                                            <span class="badge bg-secondary fs-6">{{ $coin->coins_id }}</span>
                                        </div>
                                        <small class="text-muted">ID coins tidak dapat diubah</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="coins_total" class="form-label">
                                            <i class="fas fa-coins coins-icon me-1"></i>
                                            Total Coins <span class="required">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control @error('coins_total') is-invalid @enderror" 
                                               id="coins_total" 
                                               name="coins_total" 
                                               value="{{ old('coins_total', $coin->coins_total) }}" 
                                               min="0" 
                                               required>
                                        @error('coins_total')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="coins_earned" class="form-label">
                                            <i class="fas fa-plus-circle coin-earned me-1"></i>
                                            Coins Earned
                                        </label>
                                        <input type="number" 
                                               class="form-control @error('coins_earned') is-invalid @enderror" 
                                               id="coins_earned" 
                                               name="coins_earned" 
                                               value="{{ old('coins_earned', $coin->coins_earned) }}" 
                                               min="0">
                                        @error('coins_earned')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                        </label>
                                        <textarea class="form-control @error('coins_history') is-invalid @enderror" 
                                                  id="coins_history" 
                                                  name="coins_history" 
                                                  rows="5" 
                                                  placeholder="Masukkan riwayat perolehan atau penggunaan coins...">{{ old('coins_history', $coin->coins_history) }}</textarea>
                                        @error('coins_history')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Opsional: Catat riwayat perubahan coins</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Informasi:</strong> Pastikan data yang dimasukkan sudah benar sebelum menyimpan perubahan.
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
                                    <a href="{{ route('coins.show', $coin->coins_id) }}" class="btn btn-info me-2">
                                        <i class="fas fa-eye me-1"></i>
                                        Lihat Detail
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.querySelector('form');
            const coinsTotal = document.getElementById('coins_total');
            const coinsEarned = document.getElementById('coins_earned');

            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate coins_total
                if (!coinsTotal.value || coinsTotal.value < 0) {
                    coinsTotal.classList.add('is-invalid');
                    isValid = false;
                } else {
                    coinsTotal.classList.remove('is-invalid');
                }

                // Validate coins_earned (if provided)
                if (coinsEarned.value && coinsEarned.value < 0) {
                    coinsEarned.classList.add('is-invalid');
                    isValid = false;
                } else {
                    coinsEarned.classList.remove('is-invalid');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Remove validation errors on input
            [coinsTotal, coinsEarned].forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            });
        });
    </script>
</body>
</html>