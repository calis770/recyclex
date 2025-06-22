<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Payment</title>
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
        .payment-method-badge {
            font-size: 0.85rem;
            padding: 0.4rem 0.8rem;
        }
        .subtotal-amount {
            font-weight: 600;
            font-size: 1.1rem;
        }
        .currency-symbol {
            color: #28a745;
            font-weight: bold;
        }
        .payment-icons {
            margin-right: 8px;
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
                    <i class="fas fa-credit-card text-primary"></i> Kelola Payment
                </h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                    <i class="fas fa-plus"></i> Tambah Payment
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Payment ID</th>
                            <th>Metode Pembayaran</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $index => $payment)
                        <tr>
                            <td>{{ $payments->firstItem() + $index }}</td>
                            <td><span class="badge bg-secondary">{{ $payment->payment_id }}</span></td>
                            <td>
                                @php
                                    $methodInfo = [
                                        'cash' => ['icon' => 'fas fa-money-bill-wave', 'color' => 'success', 'name' => 'Tunai'],
                                        'credit_card' => ['icon' => 'fas fa-credit-card', 'color' => 'primary', 'name' => 'Kartu Kredit'],
                                        'debit_card' => ['icon' => 'fas fa-credit-card', 'color' => 'info', 'name' => 'Kartu Debit'],
                                        'bank_transfer' => ['icon' => 'fas fa-university', 'color' => 'warning', 'name' => 'Transfer Bank'],
                                        'e_wallet' => ['icon' => 'fas fa-mobile-alt', 'color' => 'purple', 'name' => 'E-Wallet'],
                                        'crypto' => ['icon' => 'fab fa-bitcoin', 'color' => 'dark', 'name' => 'Cryptocurrency']
                                    ];
                                    $method = $methodInfo[$payment->payment_method] ?? ['icon' => 'fas fa-question', 'color' => 'secondary', 'name' => $payment->payment_method];
                                @endphp
                                <span class="badge bg-{{ $method['color'] }} payment-method-badge">
                                    <i class="{{ $method['icon'] }} payment-icons"></i>{{ $method['name'] }}
                                </span>
                            </td>
                            <td>
                                <span class="subtotal-amount">
                                    <span class="currency-symbol">Rp</span> {{ number_format($payment->subtotal, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('payments.show', $payment->payment_id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('payments.edit', $payment->payment_id) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn"
                                            title="Hapus"
                                            data-id="{{ $payment->payment_id }}"
                                            data-method="{{ $method['name'] }}"
                                            data-subtotal="{{ number_format($payment->subtotal, 0, ',', '.') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data payment</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- tambahin ini -->
    <x-footer.footer/>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Tambah Payment Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('payments.store') }}" method="POST" id="addPaymentForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select class="form-select" id="payment_method" name="payment_method" required>
                                        <option value="">Pilih Metode Pembayaran</option>
                                        <option value="cash">
                                            <i class="fas fa-money-bill-wave"></i> Tunai
                                        </option>
                                        <option value="credit_card">
                                            <i class="fas fa-credit-card"></i> Kartu Kredit
                                        </option>
                                        <option value="debit_card">
                                            <i class="fas fa-credit-card"></i> Kartu Debit
                                        </option>
                                        <option value="bank_transfer">
                                            <i class="fas fa-university"></i> Transfer Bank
                                        </option>
                                        <option value="e_wallet">
                                            <i class="fas fa-mobile-alt"></i> E-Wallet
                                        </option>
                                        <option value="crypto">
                                            <i class="fab fa-bitcoin"></i> Cryptocurrency
                                        </option>
                                    </select>
                                </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subtotal" class="form-label">Subtotal <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control" 
                                               id="subtotal" 
                                               name="subtotal" 
                                               min="0" 
                                               step="0.01" 
                                               required 
                                               placeholder="0.00">
                                    </div>
                                    <div class="form-text">Minimal Rp 0</div>
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
                    <p>Apakah Anda yakin ingin menghapus payment dengan detail berikut?</p>
                    <div class="alert alert-info">
                        <strong>Metode:</strong> <span id="delete-payment-method"></span><br>
                        <strong>Subtotal:</strong> Rp <span id="delete-payment-subtotal"></span>
                    </div>
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
            // Delete payment
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const paymentId = this.getAttribute('data-id');
                    const paymentMethod = this.getAttribute('data-method');
                    const paymentSubtotal = this.getAttribute('data-subtotal');
                    const deleteForm = document.getElementById('deleteForm');
                    const deletePaymentMethod = document.getElementById('delete-payment-method');
                    const deletePaymentSubtotal = document.getElementById('delete-payment-subtotal');
                   
                    // Set payment details in confirmation modal
                    deletePaymentMethod.textContent = paymentMethod;
                    deletePaymentSubtotal.textContent = paymentSubtotal;
                   
                    // Set form action
                    deleteForm.action = '{{ url("payments") }}/' + paymentId;
                   
                    // Show modal
                    deleteModal.show();
                });
            });

            // Format currency input
            const subtotalInput = document.getElementById('subtotal');
            subtotalInput.addEventListener('input', function() {
                // Remove non-numeric characters except decimal point
                this.value = this.value.replace(/[^0-9.]/g, '');
            });
        });
    </script>
</body>
</html>