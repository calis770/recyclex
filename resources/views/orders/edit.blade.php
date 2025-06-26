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
        .status-PACKED { background-color: #17a2b8; color: #fff; }
        .status-SENT { background-color: #6f42c1; color: #fff; }
        .status-DONE { background-color: #28a745; color: #fff; }
        .status-CANCELLED { background-color: #dc3545; color: #fff; }
        .form-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef; /* Added border */
        }
        .order-item {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background-color: #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075); /* Added subtle shadow */
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
            z-index: 10; /* Ensure it's above other elements */
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
    
    <div class="container-fluid py-4"> {{-- Added py-4 for top/bottom padding --}}
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

        <div class="d-flex justify-content-between align-items-center mt-4 mb-4 mx-4"> {{-- Added mx-4 --}}
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
                    {{ $order->status_label }} {{-- Menggunakan accessor status_label --}}
                </span>
            </div>
        </div>

        <form action="{{ route('orders.update', $order->order_id) }}" method="POST" id="editOrderForm" class="mx-4"> 
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-user"></i> Informasi Customer</h5>
                        <div class="row g-3"> {{-- Use g-3 for consistent gutter --}}
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">Customer <span class="text-danger">*</span></label>
                                <select class="form-select @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id" required>
                                    <option value="">Pilih Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->customer_id }}" 
                                                {{ old('customer_id', $order->customer_id) == $customer->customer_id ? 'selected' : '' }}>
                                            {{ $customer->customer_name }} ({{ $customer->customer_id }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="order_date" class="form-label">Tanggal Pesanan <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" 
                                        value="{{ old('order_date', $order->order_date->format('Y-m-d\TH:i')) }}" required>
                                @error('order_date')
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
                            <div class="col-md-6">
                                <label for="kota_penerima" class="form-label">Kota <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kota_penerima') is-invalid @enderror" id="kota_penerima" name="kota_penerima" 
                                       value="{{ old('kota_penerima', $order->kota_penerima) }}" required>
                                @error('kota_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi" 
                                       value="{{ old('provinsi', $order->provinsi) }}" required>
                                @error('provinsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="kode_pos_penerima" class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode_pos_penerima') is-invalid @enderror" id="kode_pos_penerima" name="kode_pos_penerima" 
                                       value="{{ old('kode_pos_penerima', $order->kode_pos_penerima) }}" required>
                                @error('kode_pos_penerima')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="note_pengiriman" class="form-label">Catatan Pengiriman (Opsional)</label>
                                <textarea class="form-control @error('note_pengiriman') is-invalid @enderror" id="note_pengiriman" name="note_pengiriman" rows="2">{{ old('note_pengiriman', $order->note_pengiriman) }}</textarea>
                                @error('note_pengiriman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5><i class="fas fa-shopping-basket"></i> Item Pesanan</h5> {{-- Updated icon --}}
                            <button type="button" class="btn btn-primary btn-sm" id="addItemBtn"> {{-- Changed to primary --}}
                                <i class="fas fa-plus"></i> Tambah Item
                            </button>
                        </div>
                        
                        <div id="orderItems">
                            @php $itemCounter = 0; @endphp
                            @foreach(old('products', $order->detailOrders) as $index => $item) {{-- Use 'products' for old() consistency with controller --}}
                            <div class="order-item position-relative" data-item-index="{{ $itemCounter }}">
                                {{-- Remove button only if more than 1 item --}}
                                @if(count(old('products', $order->detailOrders)) > 1 || $itemCounter > 0)
                                <button type="button" class="btn btn-sm btn-danger remove-item" onclick="removeItem(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                                
                                <div class="row g-3">
                                    <div class="col-md-6"> {{-- Increased product select width --}}
                                        <label class="form-label">Produk <span class="text-danger">*</span></label>
                                        <select class="form-select product-select @error('products.'.$itemCounter.'.product_id') is-invalid @enderror" name="products[{{ $itemCounter }}][product_id]" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->product_id }}" 
                                                        data-price="{{ $product->price }}" {{-- Use 'price' as defined in Product model --}}
                                                        {{ (old('products.'.$itemCounter.'.product_id', $item->product_id ?? '') == $product->product_id) ? 'selected' : '' }}>
                                                    {{ $product->product_name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('products.'.$itemCounter.'.product_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Qty <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control quantity-input @error('products.'.$itemCounter.'.quantity') is-invalid @enderror" 
                                                name="products[{{ $itemCounter }}][quantity]" 
                                                value="{{ old('products.'.$itemCounter.'.quantity', $item->quantity ?? 1) }}" min="1" required>
                                        @error('products.'.$itemCounter.'.quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4"> {{-- Adjusted width for price/total --}}
                                        <label class="form-label">Harga Satuan</label>
                                        <input type="text" class="form-control unit-price" 
                                                value="Rp {{ number_format(old('products.'.$itemCounter.'.price_at_order', $item->price_at_order ?? 0), 0, ',', '.') }}" readonly> {{-- Using price_at_order --}}
                                        <input type="hidden" name="products[{{ $itemCounter }}][price_at_order]" class="hidden-price-at-order" value="{{ old('products.'.$itemCounter.'.price_at_order', $item->price_at_order ?? 0) }}">
                                    </div>
                                    <div class="col-md-12"> {{-- Moved total to full width for clarity --}}
                                        <label class="form-label">Total Item</label>
                                        <input type="text" class="form-control item-total-display fw-bold text-success" readonly>
                                        <input type="hidden" class="item-total-value"> {{-- This stores raw calculated total for JS --}}
                                    </div>
                                </div>
                            </div>
                            @php $itemCounter++; @endphp
                            @endforeach
                        </div>

                        <div class="order-item position-relative d-none" id="itemTemplate">
                            <button type="button" class="btn btn-sm btn-danger remove-item" onclick="removeItem(this)">
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Produk <span class="text-danger">*</span></label>
                                    <select class="form-select product-select" name="products[INDEX][product_id]" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->product_id }}" data-price="{{ $product->price }}">
                                                {{ $product->product_name }} - Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Qty <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control quantity-input" 
                                            name="products[INDEX][quantity]" value="1" min="1" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga Satuan</label>
                                    <input type="text" class="form-control unit-price" readonly>
                                    <input type="hidden" name="products[INDEX][price_at_order]" class="hidden-price-at-order">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Total Item</label>
                                    <input type="text" class="form-control item-total-display fw-bold text-success" readonly>
                                    <input type="hidden" class="item-total-value">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-section">
                        <h5 class="mb-3"><i class="fas fa-clipboard-check"></i> Status Pesanan</h5> {{-- Updated icon --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
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
                        <h5 class="mb-3"><i class="fas fa-money-bill-wave"></i> Metode Pembayaran</h5> {{-- Updated icon --}}
                        <div class="mb-3">
                            <label for="payment_id" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_id') is-invalid @enderror" id="payment_id" name="payment_id" required>
                                <option value="">Pilih Metode</option>
                                @foreach($payments as $payment)
                                    <option value="{{ $payment->payment_id }}" {{ old('payment_id', $order->payment_id) == $payment->payment_id ? 'selected' : '' }}>
                                        {{ $payment->payment_method }}
                                    </option>
                                @endforeach
                            </select>
                             @error('payment_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="total-section">
                        <h5 class="mb-3"><i class="fas fa-calculator"></i> Ringkasan Pembayaran</h5> {{-- Updated icon --}}
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotalDisplay" class="fw-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak (10%):</span>
                            <span id="taxAmountDisplay" class="fw-bold">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Akhir:</strong>
                            <strong id="grandTotalDisplay" class="text-success fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                        </div>
                        {{-- Hidden inputs to store calculated values for submission --}}
                        <input type="hidden" id="hiddenSubtotal" name="subtotal" value="{{ old('subtotal', $order->subtotal) }}">
                        <input type="hidden" id="hiddenTaxAmount" name="tax_amount" value="{{ old('tax_amount', $order->tax_amount) }}">
                        <input type="hidden" id="hiddenTotalPrice" name="total_price" value="{{ old('total_price', $order->total_price) }}">
                    </div>

                    <div class="mt-4 d-grid gap-2"> {{-- Increased top margin --}}
                        <button type="submit" class="btn btn-success btn-lg"> {{-- Made buttons larger --}}
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
        // Start itemIndex from the count of existing items to ensure unique names
        let itemIndex = {{ count(old('products', $order->detailOrders)) }};
        const taxRate = 0.1; // 10% tax rate as per your controller

        document.addEventListener('DOMContentLoaded', function() {
            // Function to attach event listeners to a product item row
            function attachItemEventListeners(itemElement) {
                const productSelect = itemElement.querySelector('.product-select');
                const quantityInput = itemElement.querySelector('.quantity-input');
                const unitPriceInput = itemElement.querySelector('.unit-price');
                const itemTotalDisplay = itemElement.querySelector('.item-total-display');
                const itemTotalValueHidden = itemElement.querySelector('.item-total-value');
                const hiddenPriceAtOrder = itemElement.querySelector('.hidden-price-at-order');

                // --- Initial Population & Calculation for existing items ---
                // If this is an existing item and has old data (e.g., after validation error) or initial load
                // We need to set the unit price and initial total based on selected product/saved price_at_order
                const initialProductId = productSelect.value;
                if (initialProductId) {
                    const selectedOption = productSelect.querySelector(`option[value="${initialProductId}"]`);
                    let initialPrice = parseFloat(selectedOption?.dataset.price || 0);

                    // For existing items, try to use price_at_order first if available and valid
                    // This is crucial for reflecting the price at the time of the order
                    const oldPriceAtOrder = parseFloat(hiddenPriceAtOrder.value || 0);
                    if (oldPriceAtOrder > 0) {
                        initialPrice = oldPriceAtOrder;
                    }

                    unitPriceInput.value = formatNumber(initialPrice);
                    updateItemTotal(itemElement); // Calculate initial total for this item
                }
                // --- End Initial Population ---

                // Event Listeners for changes
                productSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = parseFloat(selectedOption.getAttribute('data-price') || 0);
                    
                    unitPriceInput.value = formatNumber(price);
                    hiddenPriceAtOrder.value = price; // Update hidden input for price_at_order
                    updateItemTotal(itemElement);
                });

                quantityInput.addEventListener('input', function() { // Use 'input' for live updates
                    updateItemTotal(itemElement);
                });

                function updateItemTotal(current_item_element) {
                    const price = parseFloat(current_item_element.querySelector('.unit-price').value.replace(/\./g, '').replace('Rp ', '') || 0); // Parse formatted number
                    const quantity = parseInt(current_item_element.querySelector('.quantity-input').value) || 0;
                    const total = price * quantity;
                    
                    current_item_element.querySelector('.item-total-display').value = 'Rp ' + formatNumber(total);
                    current_item_element.querySelector('.item-total-value').value = total;
                    
                    updateGrandTotal();
                }
            }

            // Attach event listeners to all initially loaded product items
            document.querySelectorAll('.order-item:not(#itemTemplate)').forEach(item => {
                attachItemEventListeners(item);
            });

            // "Add Item" button click handler
            document.getElementById('addItemBtn').addEventListener('click', function() {
                const template = document.getElementById('itemTemplate');
                const newItem = template.cloneNode(true);
                
                newItem.classList.remove('d-none');
                newItem.id = ''; // Remove ID to prevent duplicates
                newItem.setAttribute('data-item-index', itemIndex); // Set a unique index for tracking

                // Update name attributes for the new item's inputs/selects
                newItem.querySelectorAll('input, select').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace('INDEX', itemIndex));
                    }
                    // Reset values for new item
                    if (input.classList.contains('quantity-input')) {
                        input.value = 1;
                    } else if (input.classList.contains('product-select')) {
                        input.value = ''; // Reset dropdown
                    } else if (input.classList.contains('unit-price') || input.classList.contains('item-total-display')) {
                        input.value = '';
                    } else if (input.classList.contains('hidden-price-at-order') || input.classList.contains('item-total-value')) {
                        input.value = 0;
                    }
                });

                // Set initial price for the newly added item if a product is pre-selected (unlikely for new)
                const newProductSelect = newItem.querySelector('.product-select');
                const newUnitPriceInput = newItem.querySelector('.unit-price');
                const newHiddenPriceAtOrder = newItem.querySelector('.hidden-price-at-order');
                newProductSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = parseFloat(selectedOption.getAttribute('data-price') || 0);
                    newUnitPriceInput.value = formatNumber(price);
                    newHiddenPriceAtOrder.value = price;
                    attachItemEventListeners(newItem); // Re-attach to new item for total calculation
                });

                document.getElementById('orderItems').appendChild(newItem);
                attachItemEventListeners(newItem); // Attach listeners to the newly added item
                itemIndex++;
                updateGrandTotal(); // Recalculate grand total after adding
            });

            // --- Grand Total Calculation Function ---
            function updateGrandTotal() {
                let currentSubtotal = 0;
                document.querySelectorAll('.item-total-value').forEach(input => {
                    currentSubtotal += parseFloat(input.value) || 0;
                });
                
                const taxAmount = currentSubtotal * taxRate;
                const grandTotal = currentSubtotal + taxAmount;

                document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatNumber(currentSubtotal);
                document.getElementById('taxAmountDisplay').textContent = 'Rp ' + formatNumber(taxAmount);
                document.getElementById('grandTotalDisplay').textContent = 'Rp ' + formatNumber(grandTotal);

                // Update hidden inputs for form submission
                document.getElementById('hiddenSubtotal').value = currentSubtotal;
                document.getElementById('hiddenTaxAmount').value = taxAmount;
                document.getElementById('hiddenTotalPrice').value = grandTotal;
            }

            // Function to format numbers to Indonesian currency format without 'Rp' prefix
            function formatNumber(num) {
                return parseFloat(num).toLocaleString('id-ID');
            }

            // Initial calculation on page load
            updateGrandTotal();
        });

        // --- Remove Item Function (Global) ---
        function removeItem(button) {
            // Get all visible order items (not template and not hidden)
            const visibleItems = document.querySelectorAll('.order-item:not(#itemTemplate):not(.d-none)');
            
            if (visibleItems.length > 1) { // Ensure at least one item remains
                button.closest('.order-item').remove();
                // After removing, update the indices of remaining items to maintain correct array indexing
                // This is crucial for `name="products[INDEX][...]"`
                document.querySelectorAll('.order-item:not(#itemTemplate):not(.d-none)').forEach((item, newIdx) => {
                    item.setAttribute('data-item-index', newIdx); // Update data-index
                    item.querySelectorAll('input, select').forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            input.setAttribute('name', name.replace(/products\[\d+\]/, `products[${newIdx}]`));
                        }
                    });
                });
                updateGrandTotal();
            } else {
                alert('Pesanan harus memiliki setidaknya satu item.');
            }
        }
    </script>
</body>
</html>