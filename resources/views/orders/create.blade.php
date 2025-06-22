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
                <h3 class="card-title">Tambah Pesanan Baru</h3>
                <a href="{{ route('orders.index') }}" class="btn btn-success">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order_date" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_price" class="form-label">Total Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="total_price" name="total_price" value="{{ old('total_price') }}" min="0" step="0.01" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Selection Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pilih Produk</h5>
                        </div>
                        <div class="card-body">
                            <div id="productSection">
                                <div class="row product-row mb-3">
                                    <div class="col-md-5">
                                        <label class="form-label">Produk</label>
                                        <select class="form-select product-select" name="products[0][product_id]">
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
                                                    {{ $product->product_name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" class="form-control quantity-input" name="products[0][quantity]" min="1" value="1">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Item Qty</label>
                                        <input type="number" class="form-control item-quantity-input" name="products[0][item_quantity]" min="1" value="1">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Subtotal</label>
                                        <input type="text" class="form-control subtotal-display" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-danger remove-product d-block" style="display: none;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-success" id="addProduct">
                                <i class="fas fa-plus"></i> Tambah Produk
                            </button>
                        </div>
                    </div>

                    <!-- Total Summary -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 offset-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Subtotal:</td>
                                            <td class="text-end" id="calculatedSubtotal">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>Pajak (10%):</td>
                                            <td class="text-end" id="calculatedTax">Rp 0</td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td><strong>Total:</strong></td>
                                            <td class="text-end"><strong id="calculatedTotal">Rp 0</strong></td>
                                        </tr>
                                    </table>
                                </div>
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
        let productIndex = 1;

        // Add product row
        document.getElementById('addProduct').addEventListener('click', function() {
            const productSection = document.getElementById('productSection');
            const newRow = document.querySelector('.product-row').cloneNode(true);
            
            // Update input names
            const selects = newRow.querySelectorAll('select, input');
            selects.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${productIndex}]`);
                }
                if (input.type !== 'button') {
                    input.value = input.type === 'number' ? 1 : '';
                }
            });
            
            // Show remove button
            newRow.querySelector('.remove-product').style.display = 'block';
            
            productSection.appendChild(newRow);
            productIndex++;
            
            // Add event listeners to new row
            addEventListeners(newRow);
        });

        // Remove product row
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-product')) {
                e.target.closest('.product-row').remove();
                calculateTotal();
            }
        });

        // Add event listeners to existing and new rows
        function addEventListeners(row = document) {
            row.querySelectorAll('.product-select, .quantity-input, .item-quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    calculateRowSubtotal(this.closest('.product-row'));
                    calculateTotal();
                });
            });
        }

        // Calculate subtotal for a single row
        function calculateRowSubtotal(row) {
            const select = row.querySelector('.product-select');
            const quantity = row.querySelector('.quantity-input').value || 0;
            const itemQuantity = row.querySelector('.item-quantity-input').value || 0;
            const subtotalDisplay = row.querySelector('.subtotal-display');
            
            if (select.value && quantity && itemQuantity) {
                const price = parseFloat(select.options[select.selectedIndex].dataset.price) || 0;
                const subtotal = price * quantity * itemQuantity;
                subtotalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            } else {
                subtotalDisplay.value = '';
            }
        }

        // Calculate total
        function calculateTotal() {
            let subtotal = 0;
            
            document.querySelectorAll('.product-row').forEach(row => {
                const select = row.querySelector('.product-select');
                const quantity = row.querySelector('.quantity-input').value || 0;
                const itemQuantity = row.querySelector('.item-quantity-input').value || 0;
                
                if (select.value && quantity && itemQuantity) {
                    const price = parseFloat(select.options[select.selectedIndex].dataset.price) || 0;
                    subtotal += price * quantity * itemQuantity;
                }
            });
            
            const taxRate = 0.1;
            const tax = subtotal * taxRate;
            const total = subtotal + tax;
            
            document.getElementById('calculatedSubtotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            document.getElementById('calculatedTax').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(tax);
            document.getElementById('calculatedTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
            document.getElementById('total_price').value = total;
        }

        // Initialize event listeners
        addEventListeners();
    </script>
</body>
</html>