<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Pesanan - {{ $order->order_id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .status-badge {
            font-size: 0.8rem;
            font-weight: bold;
            padding: 0.4rem 0.8rem;
            border-radius: 1rem;
        }
        .status-UNPAID { background-color: #ffc107; color: #000; }
        .status-PACKED { background-color: #17a2b8; color: #fff; }
        .status-SENT { background-color: #6f42c1; color: #fff; }
        .status-DONE { background-color: #28a745; color: #fff; }
        .status-CANCELLED { background-color: #dc3545; color: #fff; }
        .form-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
        }
        .total-section {
            background-color: #e9ecef;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <x-header.navbar/>
    
    <div class="container-fluid py-4">
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

        <div class="d-flex justify-content-between align-items-center mt-4 mb-4 mx-4">
            <div>
                <h2>Edit Pesanan</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Kelola Pesanan</a></li> 
                        <li class="breadcrumb-item active" aria-current="page">Edit {{ $order->order_id }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <span class="status-badge status-{{ $order->status }}">
                    {{ $order->status_label }}
                </span>
            </div>
        </div>

        <form action="{{ route('orders.update', $order->order_id) }}" method="POST" id="editOrderForm" class="mx-4"> 
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-info-circle"></i> Informasi Pesanan</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="order_date" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" 
                                        value="{{ old('order_date', \Carbon\Carbon::parse($order->order_date)->format('Y-m-d\TH:i')) }}" required>
                                @error('order_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="merchant_name" class="form-label">Nama Merchant <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('merchant_name') is-invalid @enderror" id="merchant_name" name="merchant_name" 
                                       value="{{ old('merchant_name', $order->merchant_name) }}" required>
                                @error('merchant_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-box"></i> Informasi Produk</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="product_name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" 
                                       value="{{ old('product_name', $order->product_name) }}" required>
                                @error('product_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="product_image" class="form-label">URL Gambar Produk</label>
                                <input type="url" class="form-control @error('product_image') is-invalid @enderror" id="product_image" name="product_image" 
                                       value="{{ old('product_image', $order->product_image) }}">
                                @error('product_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="product_description" class="form-label">Deskripsi Produk</label>
                                <textarea class="form-control @error('product_description') is-invalid @enderror" id="product_description" name="product_description" rows="3">{{ old('product_description', $order->product_description) }}</textarea>
                                @error('product_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" 
                                       value="{{ old('quantity', $order->quantity) }}" min="1" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="unit_price" class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" 
                                       value="{{ old('unit_price', $order->unit_price) }}" min="0" required>
                                @error('unit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="total_price" class="form-label">Total Harga <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('total_price') is-invalid @enderror" id="total_price" name="total_price" 
                                       value="{{ old('total_price', $order->total_price) }}" min="0" required readonly>
                                @error('total_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-truck"></i> Informasi Pengiriman</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_penerima" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_penerima') is-invalid @enderror" id="nama_penerima" name="nama_penerima" 
                                       value="{{ old('nama_penerima', $order->nama_penerima) }}" required>
                                @error('nama_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nomor_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" 
                                       value="{{ old('nomor_hp', $order->nomor_hp) }}" required>
                                @error('nomor_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="alamat_penerima" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat_penerima') is-invalid @enderror" id="alamat_penerima" name="alamat_penerima" rows="2" required>{{ old('alamat_penerima', $order->alamat_penerima) }}</textarea>
                                @error('alamat_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="kota_penerima" class="form-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kota_penerima') is-invalid @enderror" id="kota_penerima" name="kota_penerima" 
                                       value="{{ old('kota_penerima', $order->kota_penerima) }}" required>
                                @error('kota_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" 
                                       value="{{ old('provinsi', $order->provinsi) }}" required>
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="kode_pos_penerima" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_pos_penerima') is-invalid @enderror" id="kode_pos_penerima" name="kode_pos_penerima" 
                                       value="{{ old('kode_pos_penerima', $order->kode_pos_penerima) }}" required>
                                @error('kode_pos_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="note_pengiriman" class="form-label">Catatan Pengiriman</label>
                                <textarea class="form-control @error('note_pengiriman') is-invalid @enderror" id="note_pengiriman" name="note_pengiriman" rows="2">{{ old('note_pengiriman', $order->note_pengiriman) }}</textarea>
                                @error('note_pengiriman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-clipboard-check"></i> Status Pesanan</h5>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach($statusOptions as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $order->status) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status_info" class="form-label">Keterangan Status</label>
                            <textarea class="form-control @error('status_info') is-invalid @enderror" id="status_info" name="status_info" rows="3">{{ old('status_info', $order->status_info) }}</textarea>
                            @error('status_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-money-bill-wave"></i> Metode Pembayaran</h5>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="Transfer Bank" {{ old('payment_method', $order->payment_method) == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="Cash on Delivery (COD)" {{ old('payment_method', $order->payment_method) == 'Cash on Delivery (COD)' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                                <option value="E-Wallet" {{ old('payment_method', $order->payment_method) == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="Kartu Kredit" {{ old('payment_method', $order->payment_method) == 'Kartu Kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="Kartu Debit" {{ old('payment_method', $order->payment_method) == 'Kartu Debit' ? 'selected' : '' }}>Kartu Debit</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="total-section">
                        <h5 class="mb-3"><i class="fas fa-calculator"></i> Ringkasan Pembayaran</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Jumlah:</span>
                            <span id="quantityDisplay" class="fw-bold">{{ $order->quantity }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga Satuan:</span>
                            <span id="unitPriceDisplay" class="fw-bold">Rp {{ number_format($order->unit_price, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Harga:</strong>
                            <strong id="totalPriceDisplay" class="text-success fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="mt-4 d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Update Pesanan
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-lg"> 
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-footer.footer/>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const unitPriceInput = document.getElementById('unit_price');
            const totalPriceInput = document.getElementById('total_price');
            const quantityDisplay = document.getElementById('quantityDisplay');
            const unitPriceDisplay = document.getElementById('unitPriceDisplay');
            const totalPriceDisplay = document.getElementById('totalPriceDisplay');

            function updateTotal() {
                const quantity = parseInt(quantityInput.value) || 0;
                const unitPrice = parseInt(unitPriceInput.value) || 0;
                const totalPrice = quantity * unitPrice;

                totalPriceInput.value = totalPrice;
                quantityDisplay.textContent = quantity;
                unitPriceDisplay.textContent = 'Rp ' + formatNumber(unitPrice);
                totalPriceDisplay.textContent = 'Rp ' + formatNumber(totalPrice);
            }

            function formatNumber(num) {
                return parseInt(num).toLocaleString('id-ID');
            }

            // Event listeners
            quantityInput.addEventListener('input', updateTotal);
            unitPriceInput.addEventListener('input', updateTotal);

            // Initial calculation
            updateTotal();
        });
    </script>
</body>
</html>