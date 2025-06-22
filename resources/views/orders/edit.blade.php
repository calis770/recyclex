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
        }
        .order-item {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #fff;
        }
        .item-total {
            font-weight: bold;
            color: #28a745;
        }
        .btn-add-item {
            border: 2px dashed #6c757d;
            background: transparent;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        .btn-add-item:hover {
            border-color: #28a745;
            color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }
        .remove-item {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
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
    <!-- Navbar -->
    <x-header.navbar/>
    
    <div class="container-fluid">
        <!-- Flash Messages -->
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

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
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
                    {{ $order->status_label ?? $order->status }}
                </span>
            </div>
        </div>

        <form action="{{ route('orders.update', $order->order_id) }}" method="POST" id="editOrderForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Customer Information -->
                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-user"></i> Informasi Customer</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                <select class="form-select" id="customer_id" name="customer_id" required>
                                    <option value="">Pilih Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->customer_id }}" 
                                                {{ $order->customer_id == $customer->customer_id ? 'selected' : '' }}>
                                            {{ $customer->customer_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="order_date" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="order_date" name="order_date" 
                                       value="{{ $order->order_date->format('Y-m-d\TH:i') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="form-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5><i class="fas fa-shopping-cart"></i> Item Pesanan</h5>
                            <button type="button" class="btn btn-outline-success btn-sm" id="addItemBtn">
                                <i class="fas fa-plus"></i> Tambah Item
                            </button>
                        </div>
                        
                        <div id="orderItems">
                            @foreach($order->orderItems as $index => $item)
                            <div class="order-item position-relative" data-index="{{ $index }}">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-item" onclick="removeItem(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Produk <span class="text-danger">*</span></label>
                                        <select class="form-select product-select" name="items[{{ $index }}][product_id]" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->product_id }}" 
                                                        data-price="{{ $product->unit_price }}"
                                                        {{ $item->product_id == $product->product_id ? 'selected' : '' }}>
                                                    {{ $product->product_name }} - Rp {{ number_format($product->unit_price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Qty <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control quantity-input" 
                                               name="items[{{ $index }}][quantity]" 
                                               value="{{ $item->quantity }}" min="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Harga Satuan</label>
                                        <input type="text" class="form-control unit-price" 
                                               name="items[{{ $index }}][unit_price]" 
                                               value="{{ number_format($item->unit_price, 0, ',', '.') }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Total</label>
                                        <input type="text" class="form-control item-total-display" 
                                               value="Rp {{ number_format($item->total_price, 0, ',', '.') }}" readonly>
                                        <input type="hidden" class="item-total-value" 
                                               name="items[{{ $index }}][total_price]" 
                                               value="{{ $item->total_price }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Add Item Template (Hidden) -->
                        <div class="order-item position-relative d-none" id="itemTemplate">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-item" onclick="removeItem(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Produk <span class="text-danger">*</span></label>
                                    <select class="form-select product-select" name="items[INDEX][product_id]" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->product_id }}" data-price="{{ $product->unit_price }}">
                                                {{ $product->product_name }} - Rp {{ number_format($product->unit_price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Qty <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control quantity-input" 
                                           name="items[INDEX][quantity]" value="1" min="1" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Harga Satuan</label>
                                    <input type="text" class="form-control unit-price" 
                                           name="items[INDEX][unit_price]" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Total</label>
                                    <input type="text" class="form-control item-total-display" readonly>
                                    <input type="hidden" class="item-total-value" name="items[INDEX][total_price]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Order Status -->
                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-info-circle"></i> Status Pesanan</h5>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                @foreach($statusOptions as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status_info" class="form-label">Keterangan Status</label>
                            <textarea class="form-control" id="status_info" name="status_info" rows="3">{{ $order->status_info }}</textarea>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-credit-card"></i> Informasi Pembayaran</h5>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option value="">Pilih Metode</option>
                                <option value="CASH" {{ ($order->payment->payment_method ?? '') == 'CASH' ? 'selected' : '' }}>Cash</option>
                                <option value="TRANSFER" {{ ($order->payment->payment_method ?? '') == 'TRANSFER' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="CREDIT_CARD" {{ ($order->payment->payment_method ?? '') == 'CREDIT_CARD' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="E_WALLET" {{ ($order->payment->payment_method ?? '') == 'E_WALLET' ? 'selected' : '' }}>E-Wallet</option>
                            </select>
                        </div>
                    </div>

                    <!-- Total Section -->
                    <div class="total-section">
                        <h5 class="mb-3"><i class="fas fa-calculator"></i> Total Pesanan</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotalDisplay">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total:</strong>
                            <strong id="totalDisplay">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </div>
                        <input type="hidden" id="totalPrice" name="total_price" value="{{ $order->total_price }}">
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-3 d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Pesanan
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-footer.footer/>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let itemIndex = {{ count($order->orderItems) }};

        document.addEventListener('DOMContentLoaded', function() {
            // Add new item
            document.getElementById('addItemBtn').addEventListener('click', function() {
                const template = document.getElementById('itemTemplate');
                const newItem = template.cloneNode(true);
                
                newItem.classList.remove('d-none');
                newItem.setAttribute('data-index', itemIndex);
                newItem.id = '';
                
                // Update name attributes
                const inputs = newItem.querySelectorAll('input, select');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace('INDEX', itemIndex));
                    }
                });
                
                document.getElementById('orderItems').appendChild(newItem);
                
                // Add event listeners to new item
                addItemEventListeners(newItem);
                
                itemIndex++;
            });

            // Add event listeners to existing items
            document.querySelectorAll('.order-item:not(#itemTemplate)').forEach(item => {
                addItemEventListeners(item);
            });

            function addItemEventListeners(item) {
                const productSelect = item.querySelector('.product-select');
                const quantityInput = item.querySelector('.quantity-input');
                const unitPriceInput = item.querySelector('.unit-price');
                const itemTotalDisplay = item.querySelector('.item-total-display');
                const itemTotalValue = item.querySelector('.item-total-value');

                // Product selection change
                productSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price') || 0;
                    
                    unitPriceInput.value = formatNumber(price);
                    updateItemTotal();
                });

                // Quantity change
                quantityInput.addEventListener('input', updateItemTotal);

                function updateItemTotal() {
                    const price = parseFloat(productSelect.options[productSelect.selectedIndex]?.getAttribute('data-price') || 0);
                    const quantity = parseInt(quantityInput.value) || 0;
                    const total = price * quantity;
                    
                    itemTotalDisplay.value = 'Rp ' + formatNumber(total);
                    itemTotalValue.value = total;
                    
                    updateGrandTotal();
                }
            }

            function updateGrandTotal() {
                let total = 0;
                document.querySelectorAll('.item-total-value').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                
                document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatNumber(total);
                document.getElementById('totalDisplay').textContent = 'Rp ' + formatNumber(total);
                document.getElementById('totalPrice').value = total;
            }

            function formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID');
            }
        });

        function removeItem(button) {
            if (document.querySelectorAll('.order-item:not(#itemTemplate):not(.d-none)').length > 1) {
                button.closest('.order-item').remove();
                updateGrandTotal();
            } else {
                alert('Minimal harus ada 1 item dalam pesanan');
            }
        }

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-total-value').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            
            document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatNumber(total);
            document.getElementById('totalDisplay').textContent = 'Rp ' + formatNumber(total);
            document.getElementById('totalPrice').value = total;
        }

        function formatNumber(num) {
            return parseFloat(num).toLocaleString('id-ID');
        }
    </script>
</body>
</html>