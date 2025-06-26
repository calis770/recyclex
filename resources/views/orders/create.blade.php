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
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order_date" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="">Pilih Customer</option>
                                    {{-- Assuming $customers is passed from the backend --}}
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_id" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_id" name="payment_id" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    {{-- Assuming $payments is passed from the backend --}}
                                    @foreach($payments as $payment)
                                        <option value="{{ $payment->payment_id }}" {{ old('payment_id') == $payment->payment_id ? 'selected' : '' }}>
                                            {{ $payment->payment_method }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="total_price" class="form-label">Total Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="total_price" name="total_price" value="{{ old('total_price') }}" min="0" step="0.01" required readonly> {{-- Added readonly as it's calculated --}}
                                </div>
                            </div>
                        </div>
                    </div>

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

                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 offset-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Subtotal Produk:</td>
                                            <td class="text-end" id="calculatedSubtotal">Rp 0</td>
                                        </tr>
                                        <tr>
                                            <td>Pajak (10%):</td>
                                            <td class="text-end" id="calculatedTax">Rp 0</td>
                                        </tr>
                                        <tr class="table-dark">
                                            <td><strong>Total Keseluruhan:</strong></td>
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
            const firstProductRow = document.querySelector('.product-row');
            const newRow = firstProductRow.cloneNode(true); // Clone the first row

            // Reset values and update input names for the new row
            newRow.querySelectorAll('select, input').forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${productIndex}]`);
                }
                // Reset select to default option and quantity inputs to 1
                if (input.tagName === 'SELECT') {
                    input.value = ''; // Reset select to "Pilih Produk"
                } else if (input.type === 'number') {
                    input.value = 1; // Reset quantity and item quantity to 1
                } else if (input.classList.contains('subtotal-display')) {
                    input.value = ''; // Clear subtotal display
                }
            });
            
            // Show remove button for cloned rows
            newRow.querySelector('.remove-product').style.display = 'block';
            
            productSection.appendChild(newRow);
            productIndex++;
            
            // Add event listeners to the newly added row
            addEventListeners(newRow);
            calculateTotal(); // Recalculate total after adding a new row
        });

        // Remove product row
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-product')) {
                e.target.closest('.product-row').remove();
                calculateTotal();
            }
        });

        // Add event listeners to existing and new rows
        function addEventListeners(rowContainer = document) {
            rowContainer.querySelectorAll('.product-select, .quantity-input, .item-quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    calculateRowSubtotal(this.closest('.product-row'));
                    calculateTotal();
                });
                input.addEventListener('input', function() { // Also listen to 'input' for live updates
                    calculateRowSubtotal(this.closest('.product-row'));
                    calculateTotal();
                });
            });
        }

        // Calculate subtotal for a single row
        function calculateRowSubtotal(row) {
            const select = row.querySelector('.product-select');
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const itemQuantity = parseFloat(row.querySelector('.item-quantity-input').value) || 0;
            const subtotalDisplay = row.querySelector('.subtotal-display');
            
            if (select.value) {
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
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const itemQuantity = parseFloat(row.querySelector('.item-quantity-input').value) || 0;
                
                if (select.value) {
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
            document.getElementById('total_price').value = total.toFixed(2); // Set the hidden input for total_price, format to 2 decimal places
        }

        // Initialize event listeners and calculate total on page load
        document.addEventListener('DOMContentLoaded', function() {
            addEventListeners();
            calculateTotal(); // Calculate initial total
        });
    </script>
</body>
</html>