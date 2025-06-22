<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Item Keranjang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <!-- Flash Messages -->
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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-shopping-cart"></i> Detail Item Keranjang
                </h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('carts.edit', $cart->id_cart) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('carts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Cart Item Details -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle"></i> Informasi Item
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">ID Keranjang</label>
                                            <div class="fw-bold fs-6">
                                                <span class="badge bg-secondary fs-6">{{ $cart->id_cart }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Nama Produk</label>
                                            <div class="fw-bold fs-5 text-primary">
                                                {{ $cart->product->product_name ?? 'Produk tidak ditemukan' }}
                                            </div>
                                        </div>

                                        @if($cart->product)
                                        <div class="mb-3">
                                            <label class="form-label text-muted">ID Produk</label>
                                            <div class="fw-bold">{{ $cart->product->product_id }}</div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Harga per Unit</label>
                                            <div class="fw-bold fs-5">
                                                @if($cart->product)
                                                    Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Jumlah</label>
                                            <div class="fw-bold fs-4 text-success">{{ $cart->quantity }}</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label text-muted">Total Harga</label>
                                            <div class="fw-bold fs-3 text-primary">
                                                Rp {{ number_format($cart->total_price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($cart->product)
                        <!-- Product Additional Info -->
                        <div class="card mt-4 border-info">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-box"></i> Detail Produk
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="30%" class="text-muted">Nama Produk:</td>
                                                <td class="fw-bold">{{ $cart->product->product_name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Harga:</td>
                                                <td class="fw-bold">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</td>
                                            </tr>
                                            @if(isset($cart->product->description))
                                            <tr>
                                                <td class="text-muted">Deskripsi:</td>
                                                <td>{{ $cart->product->description }}</td>
                                            </tr>
                                            @endif
                                            @if(isset($cart->product->stock))
                                            <tr>
                                                <td class="text-muted">Stok:</td>
                                                <td>
                                                    <span class="badge {{ $cart->product->stock > 10 ? 'bg-success' : ($cart->product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ $cart->product->stock }} unit
                                                    </span>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Action Panel -->
                    <div class="col-md-4">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-cogs"></i> Aksi
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('carts.edit', $cart->id_cart) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit Item
                                    </a>
                                    
                                    <form action="{{ route('carts.destroy', $cart->id_cart) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')">
                                            <i class="fas fa-trash"></i> Hapus Item
                                        </button>
                                    </form>
                                    
                                    <hr>
                                    
                                    <a href="{{ route('carts.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-shopping-cart"></i> Lihat Keranjang
                                    </a>
                                    
                                    <a href="{{ route('carts.create') }}" class="btn btn-outline-success">
                                        <i class="fas fa-plus"></i> Tambah Item Lain
                                    </a>
                                    
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-bag"></i> Lanjut Pesan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="card mt-4 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-calculator"></i> Ringkasan
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="mb-2">
                                        <small class="text-muted">Harga Satuan</small><br>
                                        <strong>
                                            @if($cart->product)
                                                Rp {{ number_format($cart->product->price, 0, ',', '.') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </strong>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Jumlah</small><br>
                                        <span class="badge bg-primary fs-6">{{ $cart->quantity }} unit</span>
                                    </div>
                                    <hr>
                                    <div>
                                        <small class="text-muted">Total</small><br>
                                        <h4 class="text-primary">Rp {{ number_format($cart->total_price, 0, ',', '.') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>