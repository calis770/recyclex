<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Akun - {{ $akun->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .page-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 2.5rem 0;
            margin-bottom: 2rem;
        }
        .detail-card {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-radius: 0.75rem;
            border: none;
            overflow: hidden;
        }
        .info-section {
            background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 5px solid #17a2b8;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
        }
        .info-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
            margin-right: 1rem;
        }
        .info-value {
            color: #212529;
            flex: 1;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.875rem;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #17a2b8, #0056b3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            margin: 0 auto 1.5rem;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .stats-card {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .activity-timeline {
            position: relative;
            padding-left: 2rem;
        }
        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #17a2b8, #0056b3);
        }
        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 0.5rem;
            width: 10px;
            height: 10px;
            background: #17a2b8;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 2px #17a2b8;
        }
        .action-buttons {
            position: sticky;
            top: 20px;
            z-index: 100;
        }
        .btn-floating {
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        .btn-floating:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .verification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 30px;
            height: 30px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
            border: 3px solid white;
        }
    </style>
</head>
<body class="bg-light">
    <!-- navbar -->
    <x-header.navbar/>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">
                        <i class="fas fa-user-circle me-3"></i>Detail Akun
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">
                        Informasi lengkap akun: <strong>{{ $akun->name }}</strong>
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('akun.edit', $akun->id_akun) }}" class="btn btn-light btn-floating me-2">
                        <i class="fas fa-edit me-2"></i>Edit Akun
                    </a>
                    <a href="{{ route('akun.index') }}" class="btn btn-light btn-floating">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
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

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Profile Summary -->
                <div class="card detail-card mb-4">
                    <div class="card-body text-center">
                        <div class="position-relative d-inline-block">
                            <div class="profile-avatar">
                                {{ strtoupper(substr($akun->name, 0, 2)) }}
                            </div>
                            @if($akun->email_verified_at)
                                <div class="verification-badge">
                                    <i class="fas fa-check"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="mb-1">{{ $akun->name }}</h3>
                        <p class="text-muted mb-3">{{ $akun->email }}</p>
                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <span class="status-badge bg-{{ $akun->level->nama_level == 'admin' ? 'danger' : ($akun->level->nama_level == 'operator' ? 'warning' : 'info') }}">
                                <i class="fas fa-layer-group me-1"></i>
                                {{ ucfirst($akun->level->nama_level) }}
                            </span>
                            <span class="status-badge bg-{{ $akun->email_verified_at ? 'success' : 'secondary' }}">
                                <i class="fas fa-{{ $akun->email_verified_at ? 'check-circle' : 'clock' }} me-1"></i>
                                {{ $akun->email_verified_at ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="card detail-card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Informasi Personal
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-section">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-id-card me-2 text-info"></i>ID Akun
                                </div>
                                <div class="info-value">
                                    <code class="bg-light px-2 py-1 rounded">#{{ $akun->id_akun }}</code>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user me-2 text-info"></i>Nama Lengkap
                                </div>
                                <div class="info-value">{{ $akun->name }}</div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-envelope me-2 text-info"></i>Email
                                </div>
                                <div class="info-value">
                                    {{ $akun->email }}
                                    @if($akun->email_verified_at)
                                        <span class="badge bg-success ms-2">
                                            <i class="fas fa-check me-1"></i>Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge bg-warning ms-2">
                                            <i class="fas fa-clock me-1"></i>Belum Terverifikasi
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-phone me-2 text-info"></i>Nomor Telepon
                                </div>
                                <div class="info-value">
                                    <a href="tel:{{ $akun->phone }}" class="text-decoration-none">
                                        {{ $akun->phone ?? 'Tidak tersedia' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="card detail-card mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cog me-2"></i>Informasi Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="info-section">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-layer-group me-2 text-warning"></i>Level Akun
                                </div>
                                <div class="info-value">
                                    <span class="badge bg-{{ $akun->level->nama_level == 'admin' ? 'danger' : ($akun->level->nama_level == 'operator' ? 'warning' : 'info') }} fs-6">
                                        {{ ucfirst($akun->level->nama_level) }}
                                    </span>
                                    <small class="text-muted ms-2">
                                        ({{ $akun->level->deskripsi ?? 'Tidak ada deskripsi' }})
                                    </small>
                                </div>
                            </div>

                            @if($akun->email_verified_at)
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-check-circle me-2 text-success"></i>Email Terverifikasi
                                </div>
                                <div class="info-value">
                                    {{ $akun->email_verified_at->format('d F Y, H:i') }} WIB
                                    <small class="text-muted ms-2">
                                        ({{ $akun->email_verified_at->diffForHumans() }})
                                    </small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="card detail-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Aktivitas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="activity-timeline">
                            @if($akun->email_verified_at)
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-success">
                                            <i class="fas fa-check-circle me-2"></i>Email Terverifikasi
                                        </h6>
                                        <p class="text-muted mb-0">
                                            Alamat email berhasil diverifikasi
                                        </p>
                                    </div>
                                    <small class="text-muted">{{ $akun->email_verified_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @else
                            <div class="timeline-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 text-warning">
                                            <i class="fas fa-clock me-2"></i>Menunggu Verifikasi Email
                                        </h6>
                                        <p class="text-muted mb-0">
                                            Email belum diverifikasi
                                        </p>
                                    </div>
                                    <small class="text-muted">Pending</small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="action-buttons">
                    <div class="card detail-card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-bolt me-2"></i>Aksi Cepat
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('akun.edit', $akun->id_akun) }}" class="btn btn-warning btn-floating">
                                    <i class="fas fa-edit me-2"></i>Edit Akun
                                </a>
                               
                                
                                <hr>
                                
                                <button type="button" class="btn btn-danger btn-floating" onclick="confirmDelete()">
                                    <i class="fas fa-trash me-2"></i>Hapus Akun
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Account Statistics -->
                    <div class="stats-card">
                        <h6 class="mb-3">
                            <i class="fas fa-chart-bar me-2"></i>Statistik Akun
                        </h6>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="h4 mb-1">{{ $akun->level->nama_level == 'admin' ? '∞' : '1' }}</div>
                                <small>Level Akses</small>
                            </div>
                            <div class="col-6">
                                <div class="h4 mb-1">{{ $akun->email_verified_at ? '1' : '0' }}</div>
                                <small>Email Verified</small>
                            </div>
                        </div>
                    </div>

                    <!-- Account Security -->
                    <div class="card detail-card">
                        <div class="card-header bg-dark text-white">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-shield-alt me-2"></i>Keamanan Akun
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-envelope {{ $akun->email_verified_at ? 'text-success' : 'text-warning' }} fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Verifikasi Email</h6>
                                    <small class="text-muted">
                                        {{ $akun->email_verified_at ? 'Email telah terverifikasi' : 'Email belum terverifikasi' }}
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-{{ $akun->email_verified_at ? 'success' : 'warning' }}">
                                        {{ $akun->email_verified_at ? 'Aktif' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-key text-info fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Password</h6>
                                    <small class="text-muted">
                                        Password terenkripsi dengan aman
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-success">Aman</span>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-shield text-primary fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Level Akses</h6>
                                    <small class="text-muted">
                                        {{ ucfirst($akun->level->nama_level) }} access level
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-{{ $akun->level->nama_level == 'admin' ? 'danger' : ($akun->level->nama_level == 'operator' ? 'warning' : 'info') }}">
                                        {{ ucfirst($akun->level->nama_level) }}
                                    </span>
                                </div>
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
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Akun
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-trash-alt text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-center mb-3">Yakin ingin menghapus akun ini?</h5>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Semua data yang terkait dengan akun ini akan dihapus secara permanen.
                    </div>
                    <div class="bg-light p-3 rounded">
                        <strong>Akun yang akan dihapus:</strong><br>
                        <i class="fas fa-user me-2"></i>{{ $akun->name }}<br>
                        <i class="fas fa-envelope me-2"></i>{{ $akun->email }}<br>
                        <i class="fas fa-id-card me-2"></i>ID: {{ $akun->id_akun }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form method="POST" action="{{ route('akun.destroy', $akun->id_akun) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirm delete function
        function confirmDelete() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Print function (optional)
        function printDetails() {
            window.print();
        }

        // Add print styles
        const printStyles = `
            @media print {
                .page-header, .action-buttons, .btn, .modal { display: none !important; }
                .detail-card { box-shadow: none !important; border: 1px solid #ddd !important; }
                body { background: white !important; }
            }
        `;
        const styleSheet = document.createElement('style');
        styleSheet.textContent = printStyles;
        document.head.appendChild(styleSheet);
    </script>
</body>
</html>