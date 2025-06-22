<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Seller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <!-- Flash Messages -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Edit Seller - {{ $seller->shop_name }}</h3>
                <a href="{{ route('sellers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('sellers.update', $seller->seller_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="seller_id" class="form-label">ID Seller</label>
                                <input type="text" class="form-control" id="seller_id" value="{{ $seller->seller_id }}" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username_seller" class="form-label">Username Seller <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('username_seller') is-invalid @enderror" 
                                       id="username_seller" name="username_seller" 
                                       value="{{ old('username_seller', $seller->username_seller) }}" required>
                                @error('username_seller')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" 
                                       value="{{ old('full_name', $seller->full_name) }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $seller->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="seller_phone_number" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('seller_phone_number') is-invalid @enderror" 
                                       id="seller_phone_number" name="seller_phone_number" 
                                       value="{{ old('seller_phone_number', $seller->seller_phone_number) }}" required>
                                @error('seller_phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="shop_name" class="form-label">Nama Toko <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('shop_name') is-invalid @enderror" 
                                       id="shop_name" name="shop_name" 
                                       value="{{ old('shop_name', $seller->shop_name) }}" required>
                                @error('shop_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="business_type" class="form-label">Jenis Bisnis <span class="text-danger">*</span></label>
                        <select class="form-select @error('business_type') is-invalid @enderror" 
                                id="business_type" name="business_type" required>
                            <option value="">Pilih Jenis Bisnis</option>
                            <option value="Fashion" {{ old('business_type', $seller->business_type) == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                            <option value="Elektronik" {{ old('business_type', $seller->business_type) == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Makanan" {{ old('business_type', $seller->business_type) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Kesehatan" {{ old('business_type', $seller->business_type) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="Kecantikan" {{ old('business_type', $seller->business_type) == 'Kecantikan' ? 'selected' : '' }}>Kecantikan</option>
                            <option value="Olahraga" {{ old('business_type', $seller->business_type) == 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                            <option value="Otomotif" {{ old('business_type', $seller->business_type) == 'Otomotif' ? 'selected' : '' }}>Otomotif</option>
                            <option value="Lainnya" {{ old('business_type', $seller->business_type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('business_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="seller_address" class="form-label">Alamat Seller <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('seller_address') is-invalid @enderror" 
                                  id="seller_address" name="seller_address" rows="3" required>{{ old('seller_address', $seller->seller_address) }}</textarea>
                        @error('seller_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="shop_description" class="form-label">Deskripsi Toko</label>
                        <textarea class="form-control @error('shop_description') is-invalid @enderror" 
                                  id="shop_description" name="shop_description" rows="4" 
                                  placeholder="Deskripsikan toko Anda...">{{ old('shop_description', $seller->shop_description) }}</textarea>
                        @error('shop_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('sellers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Seller
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>