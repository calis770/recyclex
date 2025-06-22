<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .table-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .status-badge {
            font-size: 0.75rem;
        }
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.1rem;
        }
        .page-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .stats-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #28a745;
        }
        .search-section {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .level-badge {
            font-size: 0.75rem;
            font-weight: 500;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        .text-primary {
            color: #28a745 !important;
        }
        .bg-primary {
            background-color: #28a745 !important;
        }
        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary:hover {
            background-color: #1e7e34;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <!-- navbar -->
    <x-header.navbar/>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">
                        <i class="fas fa-users me-3"></i>Kelola Akun
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Kelola data akun pengguna sistem</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('akun.create') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-plus me-2"></i>Tambah Akun Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-primary mb-0">{{ $akuns->total() }}</h3>
                            <p class="text-muted mb-0">Total Akun</p>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-info mb-0">{{ $levels->count() }}</h3>
                            <p class="text-muted mb-0">Level Akun</p>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-section">
            <form method="GET" action="{{ route('akun.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">
                        <i class="fas fa-search me-1"></i>Cari Akun
                    </label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Nama, email, atau telepon...">
                </div>
                <div class="col-md-4">
                    <label for="level_filter" class="form-label">
                        <i class="fas fa-filter me-1"></i>Filter Level
                    </label>
                    <select class="form-select" id="level_filter" name="level">
                        <option value="">Semua Level</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id_level }}" 
                                    {{ request('level') == $level->id_level ? 'selected' : '' }}>
                                {{ $level->nama_level }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Cari
                        </button>
                        <a href="{{ route('akun.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-refresh me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>Daftar Akun
                </h5>
                <div class="d-flex gap-2">
                </div>
            </div>
            <div class="card-body">
                @if($akuns->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover" id="akunTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="12%">ID Akun</th>
                                    <th width="25%">Nama Lengkap</th>
                                    <th width="25%">Email</th>
                                    <th width="18%">Telepon</th>
                                    <th width="12%">Level</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($akuns as $index => $akun)
                                    <tr>
                                        <td>{{ ($akuns->currentPage() - 1) * $akuns->perPage() + $index + 1 }}</td>
                                        <td>
                                            <code class="text-primary">{{ $akun->id_akun }}</code>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    {{ strtoupper(substr($akun->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $akun->name }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="fas fa-envelope text-muted me-1"></i>
                                            {{ $akun->email }}
                                        </td>
                                        <td>
                                            <i class="fas fa-phone text-muted me-1"></i>
                                            {{ $akun->phone }}
                                        </td>
                                        <td>
                                            <span class="badge level-badge bg-{{ $akun->isAdmin() ? 'danger' : 'success' }}">
                                                {{ $akun->getRoleName() }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('akun.show', $akun->id_akun) }}" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('akun.edit', $akun->id_akun) }}"
                                                   class="btn btn-warning btn-sm" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        title="Hapus"
                                                        onclick="confirmDelete('{{ $akun->id_akun }}', '{{ $akun->name }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $akuns->firstItem() }} sampai {{ $akuns->lastItem() }} 
                            dari {{ $akuns->total() }} data
                        </div>
                        <div>
                            {{ $akuns->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data akun</h5>
                        <p class="text-muted">Belum ada akun yang terdaftar dalam sistem.</p>
                        <a href="{{ route('akun.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Akun Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <x-footer.footer/>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun berikut?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Nama:</strong> <span id="deleteUserName"></span><br>
                        <strong>ID:</strong> <span id="deleteUserId"></span>
                    </div>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <strong>Peringatan:</strong> Data yang dihapus tidak dapat dikembalikan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Initialize DataTable
        $(document).ready(function() {
            $('#akunTable').DataTable({
                "paging": false,
                "searching": false,
                "info": false,
                "ordering": true,
                "order": [[1, "asc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [6] }
                ],
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });

        // Delete confirmation function
        function confirmDelete(id, name) {
            document.getElementById('deleteUserId').textContent = id;
            document.getElementById('deleteUserName').textContent = name;
            document.getElementById('deleteForm').action = '{{ route("akun.destroy", "") }}/' + id;
            
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
</body>
</html>