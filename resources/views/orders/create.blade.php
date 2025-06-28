<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Pesanan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                <h3 class="card-title">Tambah Pesanan Baru</h3>
                <a href="{{ route('orders.index') }}" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    
                    <!-- Order Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informasi Pesanan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order_date" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            @foreach($statusOptions as $key => $value)
                                                <option value="{{ $key }}" {{ old('status', 'UNPAID') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="">Pilih Metode Pembayaran</option>
                                            <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Transfer Bank" {{ old('payment_method') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                            <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                            <option value="E-Wallet" {{ old('payment_method') == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status_info" class="form-label">Informasi Status</label>
                                        <textarea class="form-control" id="status_info" name="status_info" rows="2" placeholder="Catatan tambahan tentang status pesanan">{{ old('status_info') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Merchant & Product Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informasi Merchant & Produk</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="merchant_name" class="form-label">Nama Merchant <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="merchant_name" name="merchant_name" value="{{ old('merchant_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">Deskripsi Produk</label>
                                        <textarea class="form-control" id="product_description" name="product_description" rows="3" placeholder="Deskripsi produk">{{ old('product_description') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="product_image" class="form-label">URL Gambar Produk</label>
                                        <input type="url" class="form-control" id="product_image" name="product_image" value="{{ old('product_image') }}" placeholder="https://example.com/image.jpg">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="unit_price" class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" min="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="total_price" class="form-label">Total Harga <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" id="total_price" name="total_price" value="{{ old('total_price') }}" min="0" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recipient Information -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informasi Penerima</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_penerima" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nomor_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat_penerima" class="form-label">Alamat Penerima <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="alamat_penerima" name="alamat_penerima" rows="3" required>{{ old('alamat_penerima') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kota_penerima" class="form-label">Kota <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="kota_penerima" name="kota_penerima" value="{{ old('kota_penerima') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kode_pos_penerima" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="kode_pos_penerima" name="kode_pos_penerima" value="{{ old('kode_pos_penerima') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="note_pengiriman" class="form-label">Catatan Pengiriman</label>
                                <textarea class="form-control" id="note_pengiriman" name="note_pengiriman" rows="2" placeholder="Catatan khusus untuk pengiriman">{{ old('note_pengiriman') }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Calculate total price when quantity or unit price changes
        function calculateTotal() {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
            const total = quantity * unitPrice;
            
            document.getElementById('total_price').value = total;
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const unitPriceInput = document.getElementById('unit_price');
            
            quantityInput.addEventListener('input', calculateTotal);
            unitPriceInput.addEventListener('input', calculateTotal);
            
            // Calculate initial total
            calculateTotal();
        });

        // Form validation
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const requiredFields = ['order_date', 'status', 'merchant_name', 'product_name', 'quantity', 'unit_price', 'nama_penerima', 'nomor_hp', 'alamat_penerima', 'kota_penerima', 'provinsi', 'kode_pos_penerima', 'payment_method'];
            
            let isValid = true;
            
            requiredFields.forEach(function(fieldName) {
                const field = document.querySelector(`[name="${fieldName}"]`);
                if (field && !field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else if (field) {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
            }
        });
    </script>
</body>
</html>