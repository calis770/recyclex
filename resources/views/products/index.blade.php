<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .rating .star {
            font-size: 1.2rem;
        }
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 0.1rem;
        }
        .modal-lg {
            max-width: 800px;
        }
        .product-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        .product-image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
        }
        #imagePreview {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <x-header.navbar/>

    <div class="container-fluid">
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
                <h3 class="card-title">Kelola Produk</h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fas fa-plus"></i> Tambah Produk
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive"> {{-- Added for better responsiveness on smaller screens --}}
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>ID Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Rating</th>
                                <th>Jumlah Terjual</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Variasi</th>
                                <th>Kategori</th> {{-- Added Category column --}}
                                <th>UMKM</th> {{-- Added UMKM column --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $product)
                            <tr>
                                <td>{{ $products->firstItem() + $index }}</td>
                                <td>{{ $product->product_id }}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($product->rating)) {{-- Use floor for full stars --}}
                                                <span class="star text-warning">★</span>
                                            @else
                                                <span class="star text-muted">★</span>
                                            @endif
                                        @endfor
                                        ({{ number_format($product->rating, 1) }}/5) {{-- Format rating to one decimal place --}}
                                    </div>
                                </td>
                                <td>{{ $product->sold }}</td>
                                <td>
                                    @if($product->image_product)
                                        <img src="{{ asset('storage/' . $product->image_product) }}"
                                             alt="{{ $product->product_name }}"
                                             class="img-thumbnail product-image">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($product->description, 50) }}</td>
                                <td>{{ Str::limit($product->variasi, 30) }}</td>
                                <td>{{ $product->category ?? '-' }}</td> {{-- Display category, with fallback --}}
                                <td>{{ $product->umkm ?? '-' }}</td> {{-- Display UMKM, with fallback --}}
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('products.show', $product->product_id) }}"
                                           class="btn btn-info btn-sm"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->product_id) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm delete-btn"
                                                title="Hapus"
                                                data-id="{{ $product->product_id }}"
                                                data-name="{{ $product->product_name }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">Tidak ada data produk</td> {{-- Updated colspan --}}
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> {{-- End table-responsive --}}

                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-footer.footer/>

    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Tambah Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="add_product_name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="add_product_name" name="product_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="add_price" class="form-label">Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="add_price" name="price" min="0" step="0.01" required> {{-- Changed step to 0.01 for decimal price --}}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="add_rating" class="form-label">Rating</label>
                                    <input type="number" class="form-control" id="add_rating" name="rating" min="0" max="5" step="0.1">
                                </div>

                                <div class="mb-3">
                                    <label for="add_sold" class="form-label">Jumlah Terjual</label>
                                    <input type="number" class="form-control" id="add_sold" name="sold" min="0">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="add_variasi" class="form-label">Variasi</label>
                                    <input type="text" class="form-control" id="add_variasi" name="variasi">
                                </div>

                                <div class="mb-3">
                                    <label for="add_category" class="form-label">Kategori</label> {{-- Added category field --}}
                                    <input type="text" class="form-control" id="add_category" name="category">
                                </div>

                                <div class="mb-3">
                                    <label for="add_umkm" class="form-label">UMKM</label> {{-- Added UMKM field --}}
                                    <input type="text" class="form-control" id="add_umkm" name="umkm">
                                </div>

                                <div class="mb-3">
                                    <label for="add_image_product" class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control" id="add_image_product" name="image_product" accept="image/*" onchange="previewImage(this, 'addImagePreview')">
                                    <div id="addImagePreview" class="mt-2"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="add_description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="add_description" name="description" rows="4"></textarea>
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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus produk <strong id="delete-product-name"></strong>?</p>
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
            // Image preview function
            window.previewImage = function(input, previewId) {
                const preview = document.getElementById(previewId);
                preview.innerHTML = ''; // Clear previous preview

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('product-image-preview', 'img-thumbnail');
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            };

            // Delete product
            const deleteModalElement = document.getElementById('deleteModal');
            const deleteModal = new bootstrap.Modal(deleteModalElement);

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const productName = this.getAttribute('data-name');
                    const deleteForm = document.getElementById('deleteForm');
                    const deleteProductName = document.getElementById('delete-product-name');

                    // Set product name in confirmation modal
                    deleteProductName.textContent = productName;

                    // Set form action
                    deleteForm.action = `{{ url("products") }}/${productId}`; // Using template literals for clarity

                    // Show modal
                    deleteModal.show();
                });
            });

            // Clear add product modal fields and image preview on close
            const addProductModalElement = document.getElementById('addProductModal');
            addProductModalElement.addEventListener('hidden.bs.modal', function () {
                const form = document.getElementById('addProductForm');
                form.reset(); // Reset all form fields
                document.getElementById('addImagePreview').innerHTML = ''; // Clear image preview
            });
        });
    </script>
</body>
</html>