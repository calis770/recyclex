<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Produk - {{ $product->product_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .product-image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Edit Produk: {{ $product->product_name }}</h3>
                <div>
                    <a href="{{ route('products.show', $product->product_id) }}" class="btn btn-info me-2">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">ID Produk</label>
                                <input type="text" class="form-control" id="product_id" name="product_id" value="{{ old('product_id', $product->product_id) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="product_name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pakaian & Aksesoris" {{ old('category', $product->category) == 'Pakaian & Aksesoris' ? 'selected' : '' }}>Pakaian & Aksesoris</option>
                                    <option value="Aksesoris Rumah" {{ old('category', $product->category) == 'Aksesoris Rumah' ? 'selected' : '' }}>Aksesoris Rumah</option>
                                    <option value="Tas & Dompet" {{ old('category', $product->category) == 'Tas & Dompet' ? 'selected' : '' }}>Tas & Dompet</option>
                                    <option value="Perlengkapan Rumah" {{ old('category', $product->category) == 'Perlengkapan Rumah' ? 'selected' : '' }}>Perlengkapan Rumah</option>
                                    {{-- Add more categories as needed --}}
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="umkm" class="form-label">UMKM</label>
                                <input type="text" name="umkm" id="umkm" value="{{ old('umkm', $product->umkm) }}" class="form-control" placeholder="Nama UMKM">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" class="form-control" id="rating" name="rating" value="{{ old('rating', $product->rating) }}" min="0" max="5" step="0.1">
                            </div>

                            <div class="mb-3">
                                <label for="sold" class="form-label">Jumlah Terjual</label>
                                <input type="number" class="form-control" id="sold" name="sold" value="{{ old('sold', $product->sold) }}" min="0">
                            </div>

                            <div class="mb-3">
                                <label for="variasi" class="form-label">Variasi</label>
                                <input type="text" class="form-control" id="variasi" name="variasi" value="{{ old('variasi', $product->variasi) }}">
                            </div>

                            <div class="mb-3">
                                <label for="image_product" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="image_product" name="image_product" accept="image/*" onchange="previewImage(this)">
                                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>

                                <div class="mt-2">
                                    @if($product->image_product)
                                        <p class="mb-1">Gambar Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $product->image_product) }}"
                                             alt="Gambar Produk {{ $product->product_name }}"
                                             class="product-image-preview img-thumbnail" id="currentImagePreview">
                                    @else
                                        <p class="mb-1 text-muted">Belum ada gambar.</p>
                                    @endif
                                    <div id="newImagePreview" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-save"></i> Perbarui Produk</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            const currentImagePreview = document.getElementById('currentImagePreview');
            const newImagePreview = document.getElementById('newImagePreview');
            newImagePreview.innerHTML = ''; // Clear any existing new image preview

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Hide the current image preview when a new one is selected
                    if (currentImagePreview) {
                        currentImagePreview.style.display = 'none';
                    }

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('product-image-preview', 'img-thumbnail');
                    newImagePreview.appendChild(img);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                // If no file is selected, show the current image preview again
                if (currentImagePreview) {
                    currentImagePreview.style.display = 'block';
                }
            }
        }
    </script>
</body>
</html>