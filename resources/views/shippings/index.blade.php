<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Shipping</title>
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
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
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
                <h3 class="card-title">Kelola Shipping</h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addShippingModal">
                    <i class="fas fa-plus"></i> Tambah Status Shipping
                </button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Shipping</th>
                            <th>Status Shipping</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shippings as $index => $shipping)
                        <tr>
                            <td>{{ $shippings->firstItem() + $index }}</td>
                            <td>{{ $shipping->shipping_id }}</td>
                            <td>
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
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('shippings.show', $shipping->shipping_id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('shippings.edit', $shipping->shipping_id) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-btn"
                                            title="Hapus"
                                            data-id="{{ $shipping->shipping_id }}"
                                            data-status="{{ $shipping->shipping_status }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data shipping</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $shippings->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- tambahin ini -->
    <x-footer.footer/>
    <!-- Add Shipping Modal -->
    <div class="modal fade" id="addShippingModal" tabindex="-1" aria-labelledby="addShippingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addShippingModalLabel">Tambah Status Shipping Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('shippings.store') }}" method="POST" id="addShippingForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="shipping_status" class="form-label">Status Shipping <span class="text-danger">*</span></label>
                            <select class="form-select" id="shipping_status" name="shipping_status" required>
                                <option value="">Pilih Status Shipping</option>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                <option value="Sedang Diproses">Sedang Diproses</option>
                                <option value="Dalam Pengiriman">Dalam Pengiriman</option>
                                <option value="Telah Diterima">Telah Diterima</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                            <div class="form-text">Atau Anda bisa mengetik status custom:</div>
                            <input type="text" class="form-control mt-2" id="custom_status" name="custom_status" placeholder="Status custom (opsional)">
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
                    <p>Apakah Anda yakin ingin menghapus status shipping <strong id="delete-shipping-status"></strong>?</p>
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
            // Handle custom status input
            const statusSelect = document.getElementById('shipping_status');
            const customStatusInput = document.getElementById('custom_status');
            
            customStatusInput.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    statusSelect.value = '';
                    statusSelect.removeAttribute('required');
                    this.setAttribute('required', '');
                    this.setAttribute('name', 'shipping_status');
                } else {
                    statusSelect.setAttribute('required', '');
                    this.removeAttribute('required');
                    this.removeAttribute('name');
                }
            });

            statusSelect.addEventListener('change', function() {
                if (this.value !== '') {
                    customStatusInput.value = '';
                    customStatusInput.removeAttribute('required');
                    customStatusInput.removeAttribute('name');
                    this.setAttribute('required', '');
                }
            });
           
            // Delete shipping
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const shippingId = this.getAttribute('data-id');
                    const shippingStatus = this.getAttribute('data-status');
                    const deleteForm = document.getElementById('deleteForm');
                    const deleteShippingStatus = document.getElementById('delete-shipping-status');
                   
                    // Set status in confirmation modal
                    deleteShippingStatus.textContent = shippingStatus;
                   
                    // Set form action
                    deleteForm.action = '{{ url("shippings") }}/' + shippingId;
                   
                    // Show modal
                    deleteModal.show();
                });
            });
        });
    </script>
</body>
</html>