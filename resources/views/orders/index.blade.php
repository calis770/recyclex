<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS untuk badge status, diterapkan ke select */
        .status-select {
            font-size: 0.8rem;
            font-weight: bold;
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem; /* Lebih kecil untuk select */
            border: 1px solid transparent; /* default border */
            width: fit-content; /* Sesuaikan lebar dengan konten */
        }
        .status-select.PACKED { background-color: #17a2b8; color: #fff; border-color: #138496; } /* info */
        .status-select.SENT { background-color: #6f42c1; color: #fff; border-color: #5d35a5; } /* purple */
        .status-select.DONE { background-color: #28a745; color: #fff; border-color: #218838; } /* success */
        .status-select.CANCELLED { background-color: #dc3545; color: #fff; border-color: #c82333; } /* danger */
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.1rem;
        }
        .modal-lg {
            max-width: 800px;
        }
        .table td {
            vertical-align: middle;
        }
        .filter-section {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
        }
        .bulk-actions {
            background-color: #e9ecef;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            display: flex; /* Flexbox for alignment */
            align-items: center; /* Center items vertically */
            gap: 1rem; /* Space between items */
        }
        .alert-fixed {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        }
    </style>
</head>
<body>
    <x-header.navbar/>

    <div class="container-fluid py-4">
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

        <div class="filter-section mt-4 mx-4"> {{-- Added mx-4 for horizontal margin --}}
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label">Filter Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="searchInput" class="form-label">Cari Pesanan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" 
                                value="{{ request('search') }}" placeholder="Cari berdasarkan ID pesanan atau nama customer">
                    </div>
                </div>
                <div class="col-md-3 d-flex justify-content-end"> {{-- Align button to the right --}}
                    <a href="{{ route('orders.create') }}" class="btn btn-success"> 
                        <i class="fas fa-plus"></i> Tambah Pesanan
                    </a>
                </div>
            </div>
        </div>

        <div class="bulk-actions mx-4" id="bulkActions" style="display: none;"> {{-- Added mx-4 --}}
            <div class="me-auto"> {{-- Pushed to the left --}}
                <span class="text-muted">
                    <span id="selectedCount">0</span> pesanan dipilih
                </span>
            </div>
            <div class="col-auto"> {{-- col-auto to keep content grouped --}}
                <select class="form-select form-select-sm" id="bulkStatusSelect">
                    <option value="">Ubah Status</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto"> {{-- col-auto to keep content grouped --}}
                <button id="bulkUpdateBtn" class="btn btn-primary btn-sm">
                    <i class="fas fa-sync"></i> Terapkan
                </button>
            </div>
        </div>

        <div class="card mx-4"> {{-- Added mx-4 --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Pesanan</h3> {{-- Changed text for clarity --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0"> {{-- Removed bottom margin if not needed --}}
                        <thead class="table-light"> {{-- Using table-light for header background --}}
                            <tr>
                                <th style="width: 1%;">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th>ID Pesanan</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr class="order-row">
                                <td>
                                    <input type="checkbox" class="form-check-input order-checkbox" value="{{ $order->order_id }}">
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $order->order_id }}</div>
                                </td>
                                <td>{{ $order->customer->customer_name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td> {{-- Added time --}}
                                <td>
                                    <div class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    {{-- Status dropdown with dynamic styling --}}
                                    <select class="form-select form-select-sm status-select {{ $order->status }}" 
                                            data-order-id="{{ $order->order_id }}" 
                                            data-original-status="{{ $order->status }}">
                                        @foreach($statusOptions as $key => $label)
                                            <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- Tooltip for status info --}}
                                    <small class="d-block text-muted mt-1" 
                                           data-bs-toggle="tooltip" data-bs-placement="top" 
                                           title="{{ $order->status_info }}">
                                           {{ Str::limit($order->status_info, 30) }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center"> {{-- Centered action buttons --}}
                                        <button class="btn btn-info btn-sm me-1"
                                                title="Lihat Detail"
                                                onclick="viewOrder('{{ $order->order_id }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a href="{{ route('orders.edit', $order->order_id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm"
                                                title="Hapus"
                                                onclick="deleteOrder('{{ $order->order_id }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Tidak ada pesanan ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Status Pesanan <span id="modalOrderId" class="fw-bold"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modalStatus" class="form-label">Status Baru</label>
                        <select class="form-select" id="modalStatus">
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modalStatusInfo" class="form-label">Keterangan Status (Opsional)</label>
                        <textarea class="form-control" id="modalStatusInfo" rows="3" 
                                    placeholder="Tambahkan informasi tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeStatusModal()">
                        Batal
                    </button>
                    <button type="button" class="btn btn-primary" onclick="confirmStatusUpdate()">
                        Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-footer.footer/>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token setup
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        let currentOrderId = null;
        const statusModalBs = new bootstrap.Modal(document.getElementById('statusModal')); // Renamed to avoid conflict

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // --- Individual Status Update Logic ---
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const orderId = this.dataset.orderId;
                const newStatus = this.value;
                const originalStatus = this.dataset.originalStatus;
                
                // Only show modal if status actually changed
                if (newStatus !== originalStatus) {
                    currentOrderId = orderId;
                    document.getElementById('modalOrderId').textContent = `(#${orderId})`;
                    document.getElementById('modalStatus').value = newStatus;
                    // Reset status info field when modal opens for a new selection
                    document.getElementById('modalStatusInfo').value = ''; 
                    statusModalBs.show();
                } else {
                    // If the user selected the current status again, just remove any info
                    // This might not be strictly necessary with `location.reload()` but good practice
                    document.getElementById('modalStatusInfo').value = '';
                }
            });
        });

        function confirmStatusUpdate() {
            const status = document.getElementById('modalStatus').value;
            const statusInfo = document.getElementById('modalStatusInfo').value;
            
            // Validate that an orderId is set
            if (!currentOrderId) {
                showAlert('Tidak ada pesanan yang dipilih.', 'error');
                closeStatusModal();
                return;
            }

            updateOrderStatus(currentOrderId, status, statusInfo);
        }

        function updateOrderStatus(orderId, status, statusInfo = '') {
            fetch(`/admin/orders/${orderId}/update-status`, { // CORRECTED ROUTE
                method: 'PATCH', // CORRECTED METHOD
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    status: status,
                    status_info: statusInfo
                })
            })
            .then(response => {
                if (!response.ok) {
                    // If server response is not OK (e.g., 400, 500), parse and throw error
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeStatusModal();
                    showAlert(data.message, 'success');
                    // Reload the page to reflect all updates, including status info and badge styling
                    location.reload(); 
                } else {
                    showAlert('Gagal mengupdate status: ' + (data.message || 'Terjadi kesalahan tidak dikenal.'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'Terjadi kesalahan saat mengupdate status.';
                if (error.errors) { // Handle Laravel validation errors
                    errorMessage += '\n' + Object.values(error.errors).flat().join('\n');
                } else if (error.message) {
                    errorMessage = 'Error: ' + error.message;
                }
                showAlert(errorMessage, 'error');
                // Importantly, reset the select value to its original state if AJAX fails
                const selectElement = document.querySelector(`[data-order-id="${orderId}"]`);
                if (selectElement) {
                    selectElement.value = selectElement.dataset.originalStatus;
                }
            });
        }

        function closeStatusModal() {
            statusModalBs.hide();
            document.getElementById('modalStatusInfo').value = '';
            // Reset the specific select element that opened the modal to its original status
            if (currentOrderId) {
                const selectElement = document.querySelector(`[data-order-id="${currentOrderId}"]`);
                if (selectElement) {
                    selectElement.value = selectElement.dataset.originalStatus;
                }
            }
            currentOrderId = null; // Clear current order ID
        }

        // --- Alert Function ---
        function showAlert(message, type = 'info') {
            const alertContainer = document.createElement('div');
            alertContainer.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show alert-fixed`;
            alertContainer.innerHTML = `
                <div>${message}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            document.body.appendChild(alertContainer);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alertContainer);
                bsAlert.close();
            }, 5000); // 5000 milliseconds = 5 seconds
        }

        // --- Search and Filter Functionality (Optimized) ---
        function applyFilters() {
            const url = new URL(window.location.origin + window.location.pathname);
            const status = document.getElementById('statusFilter').value;
            const search = document.getElementById('searchInput').value;

            if (status) {
                url.searchParams.set('status', status);
            }
            if (search) {
                url.searchParams.set('search', search);
            }
            url.searchParams.delete('page'); // Always reset pagination on filter change
            window.location.href = url.toString(); // Use href to navigate
        }

        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });

        // --- Bulk Operations Logic ---
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateBulkActions();
        });

        document.querySelectorAll('.order-checkbox').forEach(cb => {
            cb.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const selected = document.querySelectorAll('.order-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCountSpan = document.getElementById('selectedCount');
            
            selectedCountSpan.textContent = selected.length;
            if (selected.length > 0) {
                bulkActions.style.display = 'flex'; // Use flex to maintain layout
            } else {
                bulkActions.style.display = 'none';
            }
        }

        document.getElementById('bulkUpdateBtn').addEventListener('click', function() {
            const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked'))
                .map(cb => cb.value);
            const newStatus = document.getElementById('bulkStatusSelect').value;
            
            if (selectedOrders.length === 0) {
                showAlert('Pilih setidaknya satu pesanan untuk diupdate.', 'error');
                return;
            }
            
            if (!newStatus) {
                showAlert('Pilih status baru untuk pembaruan massal.', 'error');
                return;
            }
            
            if (confirm(`Yakin ingin mengubah status ${selectedOrders.length} pesanan menjadi "${document.getElementById('bulkStatusSelect').options[document.getElementById('bulkStatusSelect').selectedIndex].text}"?`)) {
                bulkUpdateStatus(selectedOrders, newStatus);
            }
        });

        function bulkUpdateStatus(orderIds, status) {
            fetch('/admin/orders/bulk-update-status', { // CORRECTED ROUTE
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    order_ids: orderIds,
                    status: status
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    location.reload(); // Reload to reflect changes
                } else {
                    showAlert('Gagal melakukan bulk update: ' + (data.message || 'Terjadi kesalahan tidak dikenal.'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'Terjadi kesalahan saat melakukan bulk update.';
                if (error.errors) {
                    errorMessage += '\n' + Object.values(error.errors).flat().join('\n');
                } else if (error.message) {
                    errorMessage = 'Error: ' + error.message;
                }
                showAlert(errorMessage, 'error');
            });
        }

        // --- Action Buttons ---
        function viewOrder(orderId) {
            window.location.href = `/admin/orders/${orderId}`; 
        }

        function deleteOrder(orderId) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan ini? Aksi ini tidak bisa dibatalkan.')) {
                fetch(`/admin/orders/${orderId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showAlert('Pesanan berhasil dihapus.', 'success');
                        location.reload();
                    } else {
                        showAlert('Gagal menghapus pesanan: ' + (data.message || 'Terjadi kesalahan tidak dikenal.'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'Terjadi kesalahan saat menghapus pesanan.';
                    if (error.message) {
                        errorMessage = 'Error: ' + error.message;
                    }
                    showAlert(errorMessage, 'error');
                });
            }
        }

        // Initial update of bulk actions display on page load
        document.addEventListener('DOMContentLoaded', updateBulkActions);
    </script>
</body>
</html>