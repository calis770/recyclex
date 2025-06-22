<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Produk - {{ $product->product_name }}</title> {{-- Added product name to title --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .rating .star {
            font-size: 1.2rem;
        }
        .product-image {
            max-height: 300px;
            object-fit: contain;
            width: 100%; /* Ensure image fills its column width */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Detail Produk: {{ $product->product_name }}</h3> {{-- Added product name to heading --}}
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 text-center mb-3"> {{-- Adjusted column width --}}
                        @if($product->image_product)
                            <img src="{{ asset('storage/' . $product->image_product) }}"
                                 alt="{{ $product->product_name }}"
                                 class="img-fluid mb-3 product-image border rounded p-2"> {{-- Added border and padding --}}
                        @else
                            <div class="text-center p-5 bg-light mb-3 border rounded"> {{-- Added border and rounded corners --}}
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="mt-2 text-muted">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-7"> {{-- Adjusted column width --}}
                        <h4 class="mb-3">{{ $product->product_name }}</h4>
                        <p><strong>ID Produk:</strong> {{ $product->product_id }}</p>
                        <p class="fs-4 fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="mb-3">
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->rating)) {{-- Use floor for full stars --}}
                                        <span class="star text-warning">★</span>
                                    @else
                                        <span class="star text-muted">★</span>
                                    @endif
                                @endfor
                                <span class="ms-2">({{ number_format($product->rating, 1) }}/5)</span> {{-- Format rating to one decimal place --}}
                            </div>
                        </div>
                        <p><strong>Jumlah Terjual:</strong> {{ $product->sold ?? 0 }}</p>
                        <p><strong>Variasi:</strong> {{ $product->variasi ?? '-' }}</p>
                        <p><strong>Kategori:</strong> {{ $product->category ?? '-' }}</p> {{-- Display category --}}
                        <p><strong>UMKM:</strong> {{ $product->umkm ?? '-' }}</p> {{-- Display UMKM --}}

                        <div class="mt-4">
                            <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit"></i> Edit Produk
                            </a>
                            <button class="btn btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Hapus Produk
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Deskripsi Produk</h5>
                    <div class="p-3 bg-light rounded border"> {{-- Added border to description box --}}
                        {{ $product->description ?? 'Tidak ada deskripsi.' }} {{-- Added period for consistent sentence ending --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Produk</h5> {{-- More specific title --}}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus produk **"{{ $product->product_name }}"**?</p> {{-- Stronger emphasis --}}
                    <p class="text-danger">Tindakan ini tidak dapat dibatalkan!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('products.destroy', $product->product_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button> {{-- More direct button text --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>