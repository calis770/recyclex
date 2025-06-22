<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Item Keranjang</title>
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
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Edit Item Keranjang
                </h3>
                <a href="{{ route('carts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <!-- Current Item Info -->
                <div class="alert alert-info mb-4">
                    <h6 class="alert-heading">
                        <i class="fas fa-info-circle"></i> Item Saat Ini
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID Keranjang:</strong> {{ $cart->id_cart }}<br>
                            <strong>Produk:</strong> {{ $cart->product->product_name ?? 'Produk tidak ditemukan' }}<br>
                        </div>
                        <div class="col-md-6">
                            <strong>Jumlah:</strong> {{ $cart->quantity }}<br>
                            <strong>Total Harga:</strong> Rp {{ number_format($cart->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('carts.update', $cart->id_cart) }}" method="POST" id="cartEditForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Produk <span class="text-danger">*</span></label>
                                <select class="form-select" id="product_id" name="product_id" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->product_id }}" 
                                                data-price="{{ $product->price }}"
                                                {{ old('product_id', $cart->product_id) == $product->product_id ? 'selected' : '' }}>
                                            {{ $product->product_name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseBtn">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" id="quantity" name="quantity" 
                                           value="{{ old('quantity', $cart->quantity) }}" min="1" required>
                                    <button class="btn btn-outline-secondary" type="button" id="increaseBtn">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Card -->
                    <div class="card mt-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calculator"></i> Perhitungan Baru
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 id="selectedProductName">{{ $cart->product->product_name ?? '-' }}</h6>
                                    <p class="text-muted mb-2">Harga per unit: <span id="selectedProductPrice">Rp {{ number_format($cart->product->price ?? 0, 0, ',', '.') }}</span></p>
                                    <p class="text-muted mb-0">Jumlah: <span id="selectedQuantity">{{ $cart->quantity }}</span></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h4 class="text-primary">Total Baru: <span id="calculatedTotal">Rp {{ number_format($cart->total_price, 0, ',', '.') }}</span></h4>
                                    <p class="text-muted mb-0">
                                        Selisih: <span id="priceDifference" class="fw-bold">Rp 0</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('carts.show', $cart->id_cart) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        <a href="{{ route('carts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get DOM elements
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseBtn');
        const increaseBtn = document.getElementById('increaseBtn');
        const selectedProductName = document.getElementById('selectedProductName');
        const selectedProductPrice = document.getElementById('selectedProductPrice');
        const selectedQuantity = document.getElementById('selectedQuantity');
        const calculatedTotal = document.getElementById('calculatedTotal');
        const priceDifference = document.getElementById('priceDifference');

        // Original values for comparison
        const originalTotal = {{ $cart->total_price }};

        // Format number as Indonesian Rupiah
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Update product details and total
        function updateProductDetails() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const quantity = parseInt(quantityInput.value) || 0;
            
            if (selectedOption.value && quantity > 0) {
                const productName = selectedOption.text.split(' - ')[0];
                const price = parseFloat(selectedOption.dataset.price) || 0;
                const total = price * quantity;
                const difference = total - originalTotal;
                
                selectedProductName.textContent = productName;
                selectedProductPrice.textContent = 'Rp ' + formatRupiah(price);
                selectedQuantity.textContent = quantity;
                calculatedTotal.textContent = 'Rp ' + formatRupiah(total);
                
                // Show price difference
                if (difference > 0) {
                    priceDifference.textContent = '+Rp ' + formatRupiah(difference);
                    priceDifference.className = 'fw-bold text-success';
                } else if (difference < 0) {
                    priceDifference.textContent = '-Rp ' + formatRupiah(Math.abs(difference));
                    priceDifference.className = 'fw-bold text-danger';
                } else {
                    priceDifference.textContent = 'Rp 0';
                    priceDifference.className = 'fw-bold text-muted';
                }
            }
        }

        // Event listeners
        productSelect.addEventListener('change', updateProductDetails);
        quantityInput.addEventListener('input', updateProductDetails);

        // Quantity control buttons
        decreaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value) || 1;
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updateProductDetails();
            }
        });

        increaseBtn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInput.value) || 0;
            quantityInput.value = currentValue + 1;
            updateProductDetails();
        });

        // Form validation
        document.getElementById('cartEditForm').addEventListener('submit', function(e) {
            const productId = productSelect.value;
            const quantity = parseInt(quantityInput.value);
            
            if (!productId) {
                e.preventDefault();
                alert('Silakan pilih produk terlebih dahulu.');
                productSelect.focus();
                return;
            }
            
            if (!quantity || quantity < 1) {
                e.preventDefault();
                alert('Jumlah harus minimal 1.');
                quantityInput.focus();
                return;
            }

            // Confirm if there are significant changes
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price) || 0;
            const newTotal = price * quantity;
            const difference = Math.abs(newTotal - originalTotal);
            
            if (difference > originalTotal * 0.5) { // If difference is more than 50%
                if (!confirm('Perubahan yang Anda buat cukup signifikan. Apakah Anda yakin ingin melanjutkan?')) {
                    e.preventDefault();
                    return;
                }
            }
        });

        // Initialize on page load
        updateProductDetails();
    </script>
</body>
</html>