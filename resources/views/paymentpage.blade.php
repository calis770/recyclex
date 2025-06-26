<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX - Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(220, 252, 231);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Profile dropdown styles */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            border-radius: 8px;
            z-index: 1;
            top: 100%;
            margin-top: 5px;
        }

        .dropdown-content a {
            color: #2b5329;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #f1f5f9;
        }

        .dropdown-content a:first-child {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .dropdown-content a:last-child {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .show {
            display: block;
        }

        .profile-button {
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .profile-button:hover {
            opacity: 0.8;
        }

        /* Search results styles */
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            max-height: 300px;
            overflow-y: auto;
            z-index: 50;
            display: none;
        }

        .search-result-item {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:hover {
            background-color: #f9fafb;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        /* Payment page specific styles */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .payment-container {
            max-width: 1000px; /* Reduced max-width slightly */
            margin: 40px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 2fr 1fr; /* Two columns: details/payment and summary */
            gap: 25px; /* Increased gap */
            flex: 1;
        }

        .payment-left-column {
            display: flex;
            flex-direction: column;
            gap: 25px; /* Gap between sections */
        }

        .shipping-details, .payment-methods, .order-summary {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08); /* More pronounced shadow */
        }

        h2 {
            font-size: 26px; /* Slightly larger title */
            font-weight: 700;
            color: #2b5329;
            margin-bottom: 25px;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            font-size: 15px; /* Slightly smaller label font */
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db; /* Lighter border */
            border-radius: 8px; /* More rounded input fields */
            font-size: 16px;
            transition: all 0.3s ease; /* Smooth transition for focus */
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: #2b5329;
            outline: none;
            box-shadow: 0 0 0 3px rgba(43, 83, 41, 0.25); /* Stronger focus ring */
        }

        .error-message {
            color: #dc2626; /* red-600 */
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        .payment-method {
            border: 1px solid #e0e0e0;
            border-radius: 10px; /* More rounded payment methods */
            padding: 18px; /* More padding */
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-method:hover {
            border-color: #2b5329;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); /* Stronger hover shadow */
        }

        .payment-method.selected {
            border-color: #2b5329;
            background-color: #eff6ee; /* Lighter green background */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12); /* Stronger selected shadow */
        }

        .payment-method input[type="radio"] {
            margin-right: 10px;
            transform: scale(1.3); /* Slightly larger radio button */
            accent-color: #2b5329;
        }

        .payment-method label {
            flex-grow: 1;
            cursor: pointer;
            font-weight: 500;
            color: #333;
            font-size: 16px;
        }

        .payment-method img {
            max-height: 30px; /* Slightly larger payment icons */
            max-width: 60px;
            object-fit: contain;
        }

        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #e0e0e0; /* Dashed separator */
        }

        .order-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .order-item .product-image {
            width: 90px; /* Larger image */
            height: 90px;
            object-fit: cover;
            border-radius: 10px; /* Rounded image corners */
            margin-right: 20px; /* More spacing */
        }

        .order-item .product-info {
            flex-grow: 1;
        }

        .order-item .product-name {
            font-weight: 600;
            color: #333;
            font-size: 17px;
            margin-bottom: 6px;
        }

        .order-item .product-quantity {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .order-item .product-price {
            font-size: 15px;
            color: #777;
        }

        .order-item .summary-amount {
            font-weight: 700; /* Bolder total per item */
            color: #2b5329;
            font-size: 18px;
            white-space: nowrap;
        }

        .payment-summary-details {
            margin-top: 25px; /* More space above summary details */
            padding-top: 25px;
            border-top: 2px solid #e0e0e0; /* Thicker border */
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px; /* More spacing for rows */
            font-size: 17px; /* Larger font for summary rows */
            color: #333;
        }

        .payment-row.total {
            font-weight: 800; /* Extra bold total */
            font-size: 22px; /* Larger total font */
            color: #2b5329;
            margin-top: 20px;
        }

        .complete-order-btn {
            width: 100%;
            padding: 18px; /* More padding for button */
            background-color: #2b5329;
            color: white;
            border: none;
            border-radius: 10px; /* More rounded button */
            font-size: 20px; /* Larger button text */
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 35px; /* More space above button */
        }

        .complete-order-btn:hover {
            background-color: #3d6e3b;
            transform: translateY(-2px); /* Slight lift on hover */
        }

        /* Custom Modal Styles (unchanged, as they are general UI components) */
        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-close-button {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .modal-close-button:hover,
        .modal-close-button:focus {
            color: #333;
            text-decoration: none;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: #2b5329;
            margin-bottom: 15px;
        }

        .modal-message {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            white-space: pre-wrap;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .payment-container {
                grid-template-columns: 1fr; /* Stack columns on small screens */
                margin: 20px auto;
                padding: 15px;
            }

            .shipping-details, .payment-methods, .order-summary {
                padding: 20px;
            }

            h2 {
                font-size: 22px;
                margin-bottom: 20px;
                padding-bottom: 10px;
            }

            .complete-order-btn {
                font-size: 18px;
                padding: 15px;
            }
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <div class="main-wrapper">
        <header class="bg-green-200 p-4 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('homepage') }}" class="flex items-center hover:opacity-80 transition-opacity">
                    <img alt="RecycleX logo" class="h-12 w-12" height="50" src="{{ asset('Assets/logo.png') }}" width="50"/>
                    <div class="ml-2">
                        <a class="text-sm text-green-700" href="#">
                            Download RecycleX App
                        </a>
                        <h1 class="text-3xl font-bold text-green-700">
                            RecycleX
                        </h1>
                    </div>
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input id="searchInput" class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text"/>
                    <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
                    <div id="searchResults" class="search-results"></div>
                </div>
                <a href="{{ route('productcart') }}" class="fas fa-shopping-cart text-green-700 text-2xl"></a>
                
                <div class="profile-dropdown">
                    <div class="profile-button flex items-center" onclick="toggleDropdown()">
                        <img alt="User  profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
                        <i class="fas fa-chevron-down text-green-700 ml-2 text-sm"></i>
                    </div>
                    <div id="profileDropdown" class="dropdown-content">
                        <a href="{{ route('profilepage') }}">
                            <i class="fas fa-user mr-2"></i>Profile
                        </a>
                        <a href="{{ route('login') }}" onclick="logout()">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="payment-container">
            <div class="payment-left-column">
                <div class="shipping-details">
                    <h2>Detail Pengiriman</h2>
                    <form id="shipping-form">
                        <div class="form-group">
                            <label for="full-name" class="form-label">Nama Lengkap *</label>
                            <input type="text" id="full-name" class="form-input" required>
                            <div id="full-name-error" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="phone-number" class="form-label">Nomor Telepon *</label>
                            <input type="text" id="phone-number" class="form-input" required>
                            <div id="phone-number-error" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="street-address" class="form-label">Alamat Lengkap (Nama Jalan, Nomor Rumah/Gedung) *</label>
                            <textarea id="street-address" class="form-textarea" rows="3" required></textarea>
                            <div id="street-address-error" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="form-label">Kota *</label>
                            <input type="text" id="city" class="form-input" required>
                            <div id="city-error" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="postal-code" class="form-label">Kode Pos *</label>
                            <input type="text" id="postal-code" class="form-input" required>
                            <div id="postal-code-error" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="province" class="form-label">Provinsi *</label>
                            <select id="province" class="form-select" required>
                                <option value="">Pilih Provinsi</option>
                                <option value="Jawa Timur">Jawa Timur</option>
                                <option value="Jawa Barat">Jawa Barat</option>
                                <option value="Jawa Tengah">Jawa Tengah</option>
                                <option value="DKI Jakarta">DKI Jakarta</option>
                                <option value="Bali">Bali</option>
                            </select>
                            <div id="province-error" class="error-message"></div>
                        </div>
                        <div class="form-group">
                            <label for="delivery-notes" class="form-label">Catatan Pengiriman (Opsional)</label>
                            <textarea id="delivery-notes" class="form-textarea" rows="2"></textarea>
                        </div>
                    </form>
                </div>

                <div class="payment-methods">
                    <h2>Metode Pembayaran</h2>
                    <div class="payment-method">
                        <input type="radio" id="bank-transfer" name="payment_method" value="bank_transfer">
                        <label for="bank-transfer">Bank Transfer</label>
                        <i class="fas fa-university text-2xl text-green-700"></i>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="credit-card" name="payment_method" value="credit_card">
                        <label for="credit-card">Kartu Kredit</label>
                        <i class="fas fa-credit-card text-2xl text-green-700"></i>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="e-wallet-gopay" name="payment_method" value="e_wallet_gopay">
                        <label for="e-wallet-gopay">GoPay</label>
                        <i class="fas fa-wallet text-2xl text-green-700"></i>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="e-wallet-ovo" name="payment_method" value="e_wallet_ovo">
                        <label for="e -wallet-ovo">OVO</label>
                        <i class="fas fa-wallet text-2xl text-green-700"></i>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="e-wallet-dana" name="payment_method" value="e_wallet_dana">
                        <label for="e-wallet-dana">DANA</label>
                        <i class="fas fa-wallet text-2xl text-green-700"></i>
                    </div>
                    <div class="payment-method">
                        <input type="radio" id="cod" name="payment_method" value="cod">
                        <label for="cod">Cash on Delivery (COD)</label>
                        <i class="fas fa-money-bill-wave text-2xl text-green-700"></i>
                    </div>
                    <div id="payment-method-error" class="error-message"></div>
                </div>
            </div>

            <div class="order-summary">
                <h2>Ringkasan Pesanan</h2>
                <div id="order-items"></div>

                <div class="payment-summary-details">
                    <div class="payment-row">
                        <span>Subtotal Produk:</span>
                        <span id="subtotal">Rp. 0</span>
                    </div>
                    <div class="payment-row">
                        <span>Biaya Pengiriman:</span>
                        <span id="shipping-cost">Rp. 0</span>
                    </div>
                    <div class="payment-row total">
                        <span>Total Pembayaran:</span>
                        <span id="total-amount">Rp. 0</span>
                    </div>
                </div>
                <button type="button" class="complete-order-btn" onclick="handleCompleteOrder()">Selesaikan Pesanan</button>
            </div>
        </div>
    </div>

    <div id="custom-modal" class="custom-modal">
        <div class="modal-content">
            <span class="modal-close-button" onclick="hideCustomModal()">&times;</span>
            <div id="modal-title" class="modal-title"></div>
            <div id="modal-message" class="modal-message"></div>
        </div>
    </div>

    <footer class="bg-green-200 p-6 mt-auto">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">About RecycleX</h3>
                <p class="text-green-800">RecycleX is a marketplace platform that connects consumers with local UMKM (Micro, Small, and Medium Enterprises) that produce recycled and sustainable products.</p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('homepage') }}" class="text-green-800 hover:underline">Home</a></li>
                    <li><a href="{{ route('homepage') }}" class="text-green-800 hover:underline">Categories</a></li>
                    <li><a href="{{ route('profilepage') }}" class="text-green-800 hover:underline">My Account</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="flex items-center text-green-800"><i class="fas fa-map-marker-alt mr-2"></i> Jl. Sustainable No. 123, Surabaya</li>
                    <li class="flex items-center text-green-800"><i class="fas fa-envelope mr-2"></i> info@recyclex.id</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-green-300 mt-6 pt-6 text-center text-green-800">
            &copy; 2025 RecycleX. All rights reserved.
        </div>
    </footer>

    <script>
        // --- Data produk yang DITERIMA DARI CONTROLLER LARAVEL ---
        let productFromDB = @json($product ?? null);
        let quantityFromDB = {{ $quantity ?? 0 }};
        let selectedVariationFromDB = @json($selectedVariation ?? null);

        let currentProduct = productFromDB;
        let currentQuantity = quantityFromDB;
        let currentSelectedVariation = selectedVariationFromDB;

        if (!currentProduct && sessionStorage.getItem('checkoutData')) {
            const storedCheckoutData = JSON.parse(sessionStorage.getItem('checkoutData'));
            if (storedCheckoutData && storedCheckoutData.items && storedCheckoutData.items.length > 0) {
                const storedItem = storedCheckoutData.items[0];
                currentProduct = {
                    product_id: storedItem.id,
                    id: storedItem.id,
                    product_name: storedItem.name,
                    price: storedItem.price,
                    image_product: storedItem.image.replace("{{ asset('storage/') }}/", ""),
                    shipping_cost: storedCheckoutData.payment_summary?.shipping || 0
                };
                currentQuantity = storedItem.quantity;
                currentSelectedVariation = {
                    name: storedItem.variation,
                    price_adjustment: storedItem.price - (currentProduct.price || 0)
                };
            }
        }

        let itemPrice = (currentProduct ? parseFloat(currentProduct.price || 0) : 0) + (currentSelectedVariation ? parseFloat(currentSelectedVariation.price_adjustment || 0) : 0);
        let subtotalProduct = itemPrice * currentQuantity;
        let shippingCost = currentProduct ? parseFloat(currentProduct.shipping_cost || 0) : 0;
        let grandTotal = subtotalProduct + shippingCost;

        function showCustomModal(title, message) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-message').textContent = message;
            document.getElementById('custom-modal').style.display = 'flex';
        }

        function hideCustomModal() {
            document.getElementById('custom-modal').style.display = 'none';
        }

        function displayOrderItems() {
            const orderItemsContainer = document.getElementById('order-items');
            orderItemsContainer.innerHTML = '';

            if (!currentProduct || currentQuantity === 0) {
                orderItemsContainer.innerHTML = '<p class="text-gray-500">Tidak ada item dalam pesanan.</p>';
                return;
            }

            const itemHTML = `
                <div class="order-item">
                    <img src="{{ asset('storage/') }}/${currentProduct.image_product}" alt="${currentProduct.product_name}" class="product-image">
                    <div class="product-info">
                        <div class="product-name">${currentProduct.product_name}</div>
                        <div class="product-quantity">Variasi: ${currentSelectedVariation?.name || 'Default'} | Qty: ${currentQuantity}</div>
                        <div class="product-price">Rp. ${itemPrice.toLocaleString('id-ID')} x ${currentQuantity}</div>
                    </div>
                    <div class="summary-amount">Rp. ${subtotalProduct.toLocaleString('id-ID')}</div>
                </div>
            `;
            orderItemsContainer.insertAdjacentHTML('beforeend', itemHTML);
        }

        function updatePaymentSummary() {
            document.getElementById('subtotal').textContent = `Rp. ${subtotalProduct.toLocaleString('id-ID')}`;
            document.getElementById('shipping-cost').textContent = `Rp. ${shippingCost.toLocaleString('id-ID')}`;
            document.getElementById('total-amount').textContent = `Rp. ${grandTotal.toLocaleString('id-ID')}`;
        }

        function setupFormValidation() {
            const form = document.getElementById('shipping-form');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', validateField);
                input.addEventListener('input', clearError);
            });
        }

        function validateField(event) {
            const field = event.target;
            const fieldName = field.id;
            const errorElement = document.getElementById(`${fieldName}-error`);
            
            if (!field.value.trim()) {
                const labelText = field.labels && field.labels[0] ? field.labels[0].textContent.replace(' *', '') : fieldName;
                showError(errorElement, `${labelText} wajib diisi`);
                return false;
            }
            
            if (fieldName === 'phone-number') {
                const phoneRegex = /^[0-9]{10,13}$/;
                if (!phoneRegex.test(field.value.trim())) {
                    showError(errorElement, 'Masukkan nomor telepon yang valid (10-13 digit)');
                    return false;
                }
            }
            
            if (fieldName === 'postal-code') {
                const postalRegex = /^[0-9]{5}$/;
                if (!postalRegex.test(field.value.trim())) {
                    showError(errorElement, 'Masukkan kode pos 5 digit yang valid');
                    return false;
                }
            }
            
            hideError(errorElement);
            return true;
        }

        function clearError(event) {
            const field = event.target;
            const fieldName = field.id;
            const errorElement = document.getElementById(`${fieldName}-error`);
            hideError(errorElement);
        }

        function setupPaymentMethodSelection() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const paymentMethodError = document.getElementById('payment-method-error');
            
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    document.querySelectorAll('.payment-method').forEach(pm => {
                        pm.classList.remove('selected');
                    });
                    this.closest('.payment-method').classList.add('selected');
                    hideError(paymentMethodError);
                });
            });
        }

        function collectFormData() {
            return {
                full_name: document.getElementById('full-name').value.trim(),
                phone_number: document.getElementById('phone-number').value.trim(),
                street_address: document.getElementById('street-address').value.trim(),
                city: document.getElementById('city').value.trim(),
                postal_code: document.getElementById('postal-code').value.trim(),
                province: document.getElementById('province').value.trim(),
                delivery_notes: document.getElementById('delivery-notes').value.trim(),
                payment_method: document.querySelector('input[name="payment_method"]:checked')?.value
            };
        }

        function getPaymentMethodName(method) {
            const methodNames = {
                'bank_transfer': 'Bank Transfer',
                'credit_card': 'Kartu Kredit',
                'e_wallet_gopay': 'GoPay',
                'e_wallet_ovo': 'OVO',
                'e_wallet_dana': 'DANA',
                'cod': 'Cash on Delivery (COD)'
            };
            return methodNames[method] || method;
        }

        function showError(errorElement, message) {
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        }

        function hideError(errorElement) {
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }
        }

        function validateForm() {
            let isValid = true;
            
            const form = document.getElementById('shipping-form');
            const requiredInputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            requiredInputs.forEach(input => {
                if (!validateField({target: input})) {
                    isValid = false;
                }
            });
            
            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
            const paymentMethodError = document.getElementById('payment-method-error');
            
            if (!selectedPaymentMethod) {
                showError(paymentMethodError, 'Silakan pilih metode pembayaran');
                isValid = false;
            } else {
                hideError(paymentMethodError);
            }
            
            return isValid;
        }

        function getOrdersFromLocalStorageForSaving() {
            try {
                const storedOrders = localStorage.getItem('paidOrders');
                if (storedOrders) {
                    const orders = JSON.parse(storedOrders);
                    if (Array.isArray(orders)) {
                        return orders;
                    }
                }
            } catch (error) {
                console.error("Error reading or parsing paidOrders from localStorage for saving:", error);
            }
            return [];
        }

        function handleCompleteOrder() {
            if (!currentProduct || currentQuantity === 0) {
                showCustomModal('Error', 'Tidak ada data produk yang ditemukan untuk menyelesaikan pesanan.');
                return;
            }

            if (validateForm()) {
                const formData = collectFormData();
                
                const orderDataToSave = {
                    merchant: currentProduct.merchant_name || "RecycleX UMKM Partner",
                    status: "UNPAID",
                    image: `{{ asset('storage/') }}/${currentProduct.image_product}`,
                    name: currentProduct.product_name,
                    description1: `Variasi: ${currentSelectedVariation?.name || 'Default'}`,
                    description2: `Kuantitas: ${currentQuantity}`,
                    price: `Rp ${itemPrice.toLocaleString('id-ID')}`,
                    statusInfo: `Pesanan dibuat pada ${new Date().toLocaleDateString('id-ID')}. Menunggu pembayaran.`,
                    total: `Rp ${grandTotal.toLocaleString('id-ID')}`,
                    order_date: new Date().toISOString(),

                    full_name: formData.full_name,
                    phone_number: formData.phone_number,
                    street_address: formData.street_address,
                    city: formData.city,
                    postal_code: formData.postal_code,
                    province: formData.province,
                    delivery_notes: formData.delivery_notes,
                    payment_method_raw: formData.payment_method,
                    payment_method_display: getPaymentMethodName(formData.payment_method)
                };

                console.log('Data Pesanan yang akan disimpan:', orderDataToSave);

                let existingOrders = getOrdersFromLocalStorageForSaving();
                existingOrders.push(orderDataToSave);
                localStorage.setItem('paidOrders', JSON.stringify(existingOrders));

                showCustomModal(
                    'Pesanan Berhasil Dibuat!',
                    `Total: Rp. ${grandTotal.toLocaleString('id-ID')}\nMetode Pembayaran: ${orderDataToSave.payment_method_display}`
                );

                sessionStorage.removeItem('checkoutData');

                setTimeout(() => {
                    window.location.href = "{{ route('myorderpage') }}";
                }, 2000);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            setupFormValidation();
            setupPaymentMethodSelection();

            displayOrderItems();
            updatePaymentSummary();
        });

        let allProducts = [];
        let isSearchActive = false;

        function performSearch(query) {
            console.log('Search functionality can be implemented here for query:', query);
        }

        function clearSearch() {
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            searchInput.value = '';
            searchResults.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performSearch(this.value);
                    document.getElementById('searchResults').style.display = 'none';
                }
            });
            document.addEventListener('click', function(e) {
                const searchContainer = e.target.closest('.relative');
                if (!searchContainer && document.getElementById('searchResults')) {
                    document.getElementById('searchResults').style.display = 'none';
                }
            });
        });

        function toggleDropdown() {
            document.getElementById("profileDropdown").classList.toggle("show");
        }
        
        function logout() {
            if (confirm('Anda yakin ingin logout?')) {
                window.location.href = "{{ route('login') }}";
            }
        }

        window.onclick = function(event) {
            if (!event.target.matches('.profile-button') && !event.target.closest('.profile-dropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>