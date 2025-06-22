<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Customer - {{ $customer->full_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .form-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 0.7rem 2rem;
            color: white;
            font-weight: 500;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }
        .btn-cancel {
            background: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 0.7rem 2rem;
            color: white;
            font-weight: 500;
        }
        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }
        .input-group .btn {
            border-radius: 0 10px 10px 0;
        }
        .input-group .form-control {
            border-radius: 10px 0 0 10px;
        }
        .required-asterisk {
            color: #dc3545;
        }
        .customer-info-badge {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            display: inline-block;
        }
        .section-divider {
            border: none;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 2rem 0;
            border-radius: 2px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Header Section -->
        <div class="header-gradient">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">
                        <i class="fas fa-user-edit me-2"></i>
                        Edit Customer
                    </h2>
                    <p class="mb-0">Mengubah informasi customer: <span class="customer-info-badge">{{ $customer->full_name }}</span></p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="customer-info-badge">
                        <i class="fas fa-id-card me-1"></i>
                        {{ $customer->customer_id }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Terdapat kesalahan dalam form:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="card form-card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit text-primary me-2"></i>
                    Form Edit Customer
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('customers.update', $customer->customer_id) }}" method="POST" id="editCustomerForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-user-circle me-1"></i>
                                Informasi Personal
                            </h6>
                            
                            <div class="mb-3">
                                <label for="full_name" class="form-label">
                                    <i class="fas fa-user text-primary me-1"></i>
                                    Nama Lengkap <span class="required-asterisk">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" 
                                       name="full_name" 
                                       value="{{ old('full_name', $customer->full_name) }}" 
                                       required 
                                       placeholder="Masukkan nama lengkap">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="username_customer" class="form-label">
                                    <i class="fas fa-at text-success me-1"></i>
                                    Username <span class="required-asterisk">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('username_customer') is-invalid @enderror" 
                                       id="username_customer" 
                                       name="username_customer" 
                                       value="{{ old('username_customer', $customer->username_customer) }}" 
                                       required 
                                       placeholder="Masukkan username">
                                @error('username_customer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope text-info me-1"></i>
                                    Email <span class="required-asterisk">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $customer->email) }}" 
                                       required 
                                       placeholder="customer@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">
                                    <i class="fas fa-phone text-warning me-1"></i>
                                    No. Telepon <span class="required-asterisk">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" 
                                       name="phone_number" 
                                       value="{{ old('phone_number', $customer->phone_number) }}" 
                                       required 
                                       placeholder="08xxxxxxxxxx">
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-shield-alt me-1"></i>
                                Keamanan & Alamat
                            </h6>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock text-danger me-1"></i>
                                    Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           minlength="6" 
                                           placeholder="Kosongkan jika tidak ingin mengubah">
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.
                                </small>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="customer_address" class="form-label">
                                    <i class="fas fa-map-marker-alt text-secondary me-1"></i>
                                    Alamat
                                </label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                          id="customer_address" 
                                          name="customer_address" 
                                          rows="6" 
                                          placeholder="Masukkan alamat lengkap customer...">{{ old('customer_address', $customer->customer_address) }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Info Box -->
                            <div class="alert alert-info">
                                <i class="fas fa-lightbulb me-2"></i>
                                <strong>Tips:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Pastikan email dan username belum digunakan customer lain</li>
                                    <li>Password minimal 6 karakter untuk keamanan</li>
                                    <li>Alamat yang lengkap memudahkan pengiriman</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="section-divider">
                    
                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('customers.show', $customer->customer_id) }}" 
                                   class="btn btn-cancel">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-save">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Navigation Card -->
        <div class="card form-card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Navigasi Cepat</h6>
                        <small class="text-muted">Akses cepat ke halaman lain</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list me-1"></i>Daftar Customer
                        </a>
                        <a href="{{ route('customers.show', $customer->customer_id) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye me-1"></i>Detail Customer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            window.togglePassword = function(inputId) {
                const input = document.getElementById(inputId);
                const eye = document.getElementById(inputId + '-eye');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    eye.classList.remove('fa-eye');
                    eye.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    eye.classList.remove('fa-eye-slash');
                    eye.classList.add('fa-eye');
                }
            };
            
            // Form validation feedback
            const form = document.getElementById('editCustomerForm');
            const inputs = form.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.hasAttribute('required') && !this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
            
            // Auto-format phone number
            const phoneInput = document.getElementById('phone_number');
            phoneInput.addEventListener('input', function() {
                // Remove non-digit characters
                let value = this.value.replace(/\D/g, '');
                
                // Limit to reasonable phone number length
                if (value.length > 15) {
                    value = value.substring(0, 15);
                }
                
                this.value = value;
            });
            
            // Email validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.classList.add('is-invalid');
                    if (!this.parentNode.querySelector('.invalid-feedback')) {
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = 'Format email tidak valid';
                        this.parentNode.appendChild(feedback);
                    }
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>
</html>