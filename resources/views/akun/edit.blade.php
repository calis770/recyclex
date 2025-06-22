<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Akun - {{ $akun->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .page-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .form-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }
        .form-section {
            border-left: 4px solid #28a745;
            background-color: #f8fff9;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.25rem;
        }
        .required {
            color: #dc3545;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .password-toggle {
            cursor: pointer;
        }
        .password-strength {
            height: 5px;
            border-radius: 3px;
            transition: all 0.3s ease;
        }
        .strength-weak { background-color: #dc3545; }
        .strength-medium { background-color: #ffc107; }
        .strength-strong { background-color: #28a745; }
        .info-badge {
            background-color: #e8f5e8;
            border: 1px solid #28a745;
            color: #155724;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }
        .text-warning { color: #28a745 !important; }
        .fw-bold.text-warning { color: #28a745 !important; }
        .btn-warning {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .btn-warning:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: white;
        }
        .btn-outline-warning {
            border-color: #28a745;
            color: #28a745;
        }
        .btn-outline-warning:hover {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .bg-warning {
            background-color: #28a745 !important;
        }
        .card-header.bg-warning {
            background-color: #28a745 !important;
            color: white !important;
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
                <div class="col-md-8">
                    <h1 class="mb-0">
                        <i class="fas fa-user-edit me-3"></i>Edit Akun
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">
                        Mengedit akun: <strong>{{ $akun->name }}</strong>
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('akun.show', $akun->id_akun) }}" class="btn btn-light me-2">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                    <a href="{{ route('akun.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Flash Messages -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Account Info -->
                <div class="info-badge">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>ID Akun:</strong> {{ $akun->id_akun }} | 
                        </div>
                        <div class="col-md-4 text-md-end">
                            <span class="badge bg-{{ $akun->level->nama_level == 'admin' ? 'danger' : ($akun->level->nama_level == 'operator' ? 'warning' : 'info') }} fs-6">
                                {{ ucfirst($akun->level->nama_level) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card form-card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-edit me-2"></i>Form Edit Akun
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('akun.update', $akun->id_akun) }}" id="editForm">
                            @csrf
                            @method('PUT')
                            
                            <!-- Informasi Personal -->
                            <div class="form-section">
                                <h6 class="fw-bold text-warning mb-3">
                                    <i class="fas fa-user me-2"></i>Informasi Personal
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">
                                            Nama Lengkap <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $akun->name) }}" 
                                                   placeholder="Masukkan nama lengkap"
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">
                                            Nomor Telepon <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" 
                                                   class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" 
                                                   name="phone" 
                                                   value="{{ old('phone', $akun->phone) }}" 
                                                   placeholder="Contoh: 081234567890"
                                                   required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Format: 08xxxxxxxxxx</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi Akun -->
                            <div class="form-section">
                                <h6 class="fw-bold text-warning mb-3">
                                    <i class="fas fa-envelope me-2"></i>Informasi Akun
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">
                                            Email <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $akun->email) }}" 
                                                   placeholder="user@example.com"
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="id_level" class="form-label">
                                            Level Akun <span class="required">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-layer-group"></i>
                                            </span>
                                            <select class="form-select @error('id_level') is-invalid @enderror" 
                                                    id="id_level" 
                                                    name="id_level" 
                                                    required>
                                                <option value="">Pilih Level Akun</option>
                                                @foreach($levels as $level)
                                                    <option value="{{ $level->id_level }}" 
                                                            {{ (old('id_level', $akun->id_level) == $level->id_level) ? 'selected' : '' }}>
                                                        {{ $level->nama_level }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_level')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Keamanan -->
                            <div class="form-section">
                                <h6 class="fw-bold text-warning mb-3">
                                    <i class="fas fa-shield-alt me-2"></i>Keamanan
                                </h6>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Kosongkan field password jika tidak ingin mengubah password
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">
                                            Password Baru (Opsional)
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" 
                                                   name="password" 
                                                   placeholder="Masukkan password baru">
                                            <button type="button" class="btn btn-outline-secondary password-toggle" 
                                                    onclick="togglePassword('password')">
                                                <i class="fas fa-eye" id="password-icon"></i>
                                            </button>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="password-strength mt-2" id="password-strength"></div>
                                        <small class="text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label">
                                            Konfirmasi Password Baru
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                            <input type="password" 
                                                   class="form-control" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   placeholder="Ulangi password baru">
                                            <button type="button" class="btn btn-outline-secondary password-toggle" 
                                                    onclick="togglePassword('password_confirmation')">
                                                <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-3 pt-3">
                                <button type="submit" class="btn btn-warning btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('akun.show', $akun->id_akun) }}" class="btn btn-outline-secondary btn-lg px-4">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="reset" class="btn btn-outline-warning btn-lg px-4">
                                    <i class="fas fa-undo me-2"></i>Reset Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength');
            
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.className = 'password-strength';
                return;
            }
            
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            const percentage = (strength / 5) * 100;
            strengthBar.style.width = percentage + '%';
            
            if (strength <= 2) {
                strengthBar.className = 'password-strength strength-weak';
            } else if (strength <= 3) {
                strengthBar.className = 'password-strength strength-medium';
            } else {
                strengthBar.className = 'password-strength strength-strong';
            }
        });

        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 13) {
                value = value.slice(0, 13);
            }
            this.value = value;
        });

        // Form validation
        document.getElementById('editForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (password && password !== passwordConfirmation) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            
            if (password && password.length < 8) {
                e.preventDefault();
                alert('Password minimal 8 karakter!');
                return false;
            }
        });
    </script>
</body>
</html>