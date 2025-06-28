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
            border-radius: 0.5rem;
            border: 1px solid transparent;
            width: fit-content;
        }
        .status-select.PACKED { background-color: #17a2b8; color: #fff; border-color: #138496; }
        .status-select.SENT { background-color: #6f42c1; color: #fff; border-color: #5d35a5; }
        .status-select.DONE { background-color: #28a745; color: #fff; border-color: #218838; }
        .status-select.CANCELLED { background-color: #dc3545; color: #fff; border-color: #c82333; }
        
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
            display: flex;
            align-items: center;
            gap: 1rem;
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

        <div class="filter-section mt-4 mx-4">
            <form method="GET" action="{{ route('orders.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Filter Status</label>
                        <select class="form-select" id="statusFilter" name="status" onchange="document.getElementById('filterForm').submit()">
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
                            <input type="text" class="form-control" id="searchInput" name="search"
                                    value="{{ request('search') }}" placeholder="Cari berdasarkan ID pesanan atau nama customer">
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <a href="{{ route('orders.create') }}" class="btn btn-success"> 
                            <i class="fas fa-plus"></i> Tambah Pesanan
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="bulk-actions mx-4" id="bulkActions" style="display: none;">
            <div class="me-auto">
                <span class="text-muted">
                    <span id="selectedCount">0</span> pesanan dipilih
                </span>
            </div>
            <div class="col-auto">
                <select class="form-select form-select-sm" id="bulkStatusSelect">
                    <option value="">Ubah Status</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button id="bulkUpdateBtn" class="btn btn-primary btn-sm">
                    <i class="fas fa-sync"></i> Terapkan
                </button>
            </div>
        </div>

        <div class="card mx-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Daftar Pesanan</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
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
                                <td>{{ $order->nama_penerima ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <select class="form-select form-select-sm status-select {{ $order->status }}" 
                                            data-order-id="{{ $order->order_id }}" 
                                            data-original-status="{{ $order->status }}">
                                        @foreach($statusOptions as $key => $label)
                                            <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($order->status_info)
                                        <small class="d-block text-muted mt-1" 
                                               data-bs-toggle="tooltip" data-bs-placement="top" 
                                               title="{{ $order->status_info }}">
                                               {{ Str::limit($order->status_info, 30) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-primary btn-sm me-1" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
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

    <!-- Status Update Modal -->
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
        const statusModalBs = new bootstrap.Modal(document.getElementById('statusModal'));

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize bulk actions
            updateBulkActions();
        });

        // Individual Status Update Logic
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                const orderId = this.dataset.orderId;
                const newStatus = this.value;
                const originalStatus = this.dataset.originalStatus;
                
                if (newStatus !== originalStatus) {
                    currentOrderId = orderId;
                    document.getElementById('modalOrderId').textContent = `(#${orderId})`;
                    document.getElementById('modalStatus').value = newStatus;
                    document.getElementById('modalStatusInfo').value = ''; 
                    statusModalBs.show();
                } else {
                    // Reset to original if same status selected
                    this.value = originalStatus;
                }
            });
        });

        function confirmStatusUpdate() {
            const status = document.getElementById('modalStatus').value;
            const statusInfo = document.getElementById('modalStatusInfo').value;
            
            if (!currentOrderId) {
                showAlert('Tidak ada pesanan yang dipilih.', 'error');
                closeStatusModal();
                return;
            }

            updateOrderStatus(currentOrderId, status, statusInfo);
        }

        function updateOrderStatus(orderId, status, statusInfo = '') {
            const submitBtn = document.querySelector('#statusModal .btn-primary');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;

            fetch(`/admin/orders/${orderId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    status: status,
                    status_info: statusInfo
                })
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error(`Server mengembalikan ${contentType} bukan JSON. Status: ${response.status}`);
                }
                
                if (!response.ok) {
                    return response.json().then(err => { 
                        throw new Error(err.message || `HTTP Error: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeStatusModal();
                    showAlert(data.message || 'Status berhasil diupdate', 'success');
                    location.reload(); 
                } else {
                    throw new Error(data.message || 'Update gagal');
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                let errorMessage = 'Terjadi kesalahan saat mengupdate status.';
                if (error.message.includes('application/json')) {
                    errorMessage = 'Server error: Kemungkinan ada masalah dengan route atau controller.';
                } else if (error.message) {
                    errorMessage = error.message;
                }
                
                showAlert(errorMessage, 'error');
                
                const selectElement = document.querySelector(`[data-order-id="${orderId}"]`);
                if (selectElement) {
                    selectElement.value = selectElement.dataset.originalStatus;
                }
            });
        }

        function closeStatusModal() {
            statusModalBs.hide();
            currentOrderId = null;
            
            // Reset form
            document.getElementById('modalStatus').value = '';
            document.getElementById('modalStatusInfo').value = '';
        }

        // Bulk Update Functions
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.order-checkbox:checked');
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            selectedCount.textContent = checkboxes.length;
            
            if (checkboxes.length > 0) {
                bulkActions.style.display = 'flex';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        // Individual checkbox change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('order-checkbox')) {
                updateBulkActions();
                
                // Update select all checkbox
                const allCheckboxes = document.querySelectorAll('.order-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.order-checkbox:checked');
                const selectAllCheckbox = document.getElementById('selectAll');
                
                selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
            }
        });

        // Bulk Update Button
        document.getElementById('bulkUpdateBtn').addEventListener('click', function() {
            const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(cb => cb.value);
            const newStatus = document.getElementById('bulkStatusSelect').value;
            
            if (selectedOrders.length === 0) {
                showAlert('Pilih minimal satu pesanan untuk diupdate.', 'warning');
                return;
            }
            
            if (!newStatus) {
                showAlert('Pilih status yang akan diterapkan.', 'warning');
                return;
            }
            
            if (confirm(`Apakah Anda yakin ingin mengubah status ${selectedOrders.length} pesanan ke ${newStatus}?`)) {
                bulkUpdateStatus(selectedOrders, newStatus);
            }
        });

        function bulkUpdateStatus(orderIds, status) {
            const submitBtn = document.getElementById('bulkUpdateBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;

            fetch('/admin/orders/bulk-update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    order_ids: orderIds,
                    status: status
                })
            })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error(`Server mengembalikan ${contentType} bukan JSON. Status: ${response.status}`);
                }
                
                if (!response.ok) {
                    return response.json().then(err => { 
                        throw new Error(err.message || `HTTP Error: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert(data.message || 'Bulk update berhasil', 'success');
                    location.reload();
                } else {
                    throw new Error(data.message || 'Bulk update gagal');
                }
            })
            .catch(error => {
                console.error('Bulk update error:', error);
                
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                let errorMessage = 'Terjadi kesalahan saat melakukan bulk update.';
                if (error.message.includes('application/json')) {
                    errorMessage = 'Server error: Cek route dan controller untuk bulk update.';
                } else if (error.message) {
                    errorMessage = error.message;
                }
                
                showAlert(errorMessage, 'error');
            });
        }

        // Delete Function
        function deleteOrder(orderId) {
            if (confirm('Apakah Anda yakin ingin menghapus pesanan ini? Aksi ini tidak bisa dibatalkan.')) {
                fetch(`/admin/orders/${orderId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error(`Server mengembalikan ${contentType} bukan JSON. Status: ${response.status}`);
                    }
                    
                    if (!response.ok) {
                        return response.json().then(err => { 
                            throw new Error(err.message || `HTTP Error: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showAlert('Pesanan berhasil dihapus.', 'success');
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Delete gagal');
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    let errorMessage = 'Terjadi kesalahan saat menghapus pesanan.';
                    if (error.message) {
                        errorMessage = error.message;
                    }
                    showAlert(errorMessage, 'error');
                });
            }
        }

        // Alert Function
        function showAlert(message, type = 'info') {
            const alertClass = type === 'error' ? 'alert-danger' : `alert-${type}`;
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show alert-fixed" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Remove existing alerts
            document.querySelectorAll('.alert-fixed').forEach(alert => alert.remove());
            
            // Add new alert
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                const alert = document.querySelector('.alert-fixed');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    </script>
</body>
</html>