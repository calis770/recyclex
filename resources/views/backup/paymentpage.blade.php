<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX - Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: rgb(240, 255, 240);
            margin: 0;
            padding: 0;
        }

        .payment-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 15px;
            color: #2b5329;
            font-size: 1.5rem;
        }

        .section {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-title {
            color: #2b5329;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 10px;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-name {
            font-weight: bold;
            color: #333;
            font-size: 1rem;
        }

        .product-quantity, .product-price {
            color: #666;
            font-size: 0.8rem;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            box-sizing: border-box;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #2b5329;
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .payment-method {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .payment-method:hover, .payment-method.selected {
            border-color: #2b5329;
        }

        .payment-method input[type="radio"] {
            margin-right: 8px;
        }

        .payment-method label {
            flex-grow: 1;
            color: #333;
            font-size: 0.9rem;
        }

        .payment-method img {
            height: 20px;
            width: auto;
            display: inline-block;
            margin-right: 5px;
            vertical-align: middle;
        }

        .payment-summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .summary-label {
            font-weight: bold;
            color: #333;
        }

        .summary-amount {
            color: #2b5329;
            font-weight: bold;
        }

        .pay-button {
            background-color: #2b5329;
            color: white;
            border: none;
            padding: 12px 15px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            transition: background-color 0.3s;
            margin-top: 15px;
        }

        .pay-button:hover {
            background-color: #1e3b1d;
        }

        .pay-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .required {
            color: #e74c3c;
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <header class="bg-green-200 p-4 flex justify-between items-center">
        <div class="flex items-center">
            <a href="{{ route('homepage') }}" class="flex items-center hover:opacity-80 transition-opacity">
            <img alt="RecycleX logo" class="h-12 w-12" height="50" src="Assets/logo.png" width="50"/>
            <div class="ml-2">
                <a class="text-sm text-green-700" href="#">
                    Download RecycleX App
                </a>
                <h1 class="text-3xl font-bold text-green-700">
                    RecycleX
                </h1>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text"/>
                <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
            </div>
            <a href="#" class="fas fa-shopping-cart text-green-700 text-2xl"></a>
            <a href="#" class="flex items-center">
                <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="Assets/profile.jpg" width="40"/>
            </a>
        </div>
    </header>

    <div class="payment-container">
        <h2 class="payment-header">Checkout</h2>

        <!-- Order Summary Section -->
        <div class="section">
            <h3 class="section-title">Order Summary</h3>
            <div id="order-items"></div>
        </div>

        <!-- Shipping Address Section -->
        <div class="section">
            <h3 class="section-title">Shipping Address <span class="required">*</span></h3>
            <form id="shipping-form">
                <div class="form-group">
                    <label class="form-label" for="full-name">Full Name <span class="required">*</span></label>
                    <input type="text" id="full-name" name="full-name" class="form-input" required>
                    <div class="error-message" id="full-name-error">Please enter your full name</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone-number">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone-number" name="phone-number" class="form-input" placeholder="e.g., 08123456789" required>
                    <div class="error-message" id="phone-number-error">Please enter a valid phone number</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="street-address">Street Address <span class="required">*</span></label>
                    <textarea id="street-address" name="street-address" class="form-textarea" placeholder="Enter your complete street address" required></textarea>
                    <div class="error-message" id="street-address-error">Please enter your street address</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="city">City <span class="required">*</span></label>
                        <input type="text" id="city" name="city" class="form-input" required>
                        <div class="error-message" id="city-error">Please enter your city</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="postal-code">Postal Code <span class="required">*</span></label>
                        <input type="text" id="postal-code" name="postal-code" class="form-input" placeholder="e.g., 12345" required>
                        <div class="error-message" id="postal-code-error">Please enter your postal code</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="province">Province <span class="required">*</span></label>
                    <select id="province" name="province" class="form-input" required>
                        <option value="">Select Province</option>
                        <option value="Jawa Timur">Jawa Timur</option>
                        <option value="Jawa Tengah">Jawa Tengah</option>
                        <option value="Jawa Barat">Jawa Barat</option>
                        <option value="DKI Jakarta">DKI Jakarta</option>
                        <option value="Banten">Banten</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Bali">Bali</option>
                        <option value="Sumatera Utara">Sumatera Utara</option>
                        <option value="Sumatera Barat">Sumatera Barat</option>
                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                    </select>
                    <div class="error-message" id="province-error">Please select your province</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="delivery-notes">Delivery Notes (Optional)</label>
                    <textarea id="delivery-notes" name="delivery-notes" class="form-textarea" placeholder="Any special instructions for delivery..."></textarea>
                </div>
            </form>
        </div>

        <!-- Payment Method Section -->
        <div class="section">
            <h3 class="section-title">Payment Method <span class="required">*</span></h3>
            <div class="payment-method">
                <input type="radio" id="bank_transfer" name="payment_method" value="bank_transfer">
                <label for="bank_transfer"><i class="fas fa-university mr-2"></i> Bank Transfer</label>
            </div>
            <div class="payment-method">
                <input type="radio" id="credit_card" name="payment_method" value="credit_card">
                <label for="credit_card"><i class="far fa-credit-card mr-2"></i> Credit Card</label>
            </div>
            <div class="payment-method">
                <input type="radio" id="e_wallet_gopay" name="payment_method" value="e_wallet_gopay">
                <label for="e_wallet_gopay"><img src="Assets/gopay.png" alt="GoPay" class="h-5 w-auto inline-block mr-2"> GoPay</label>
            </div>
            <div class="payment-method">
                <input type="radio" id="e_wallet_ovo" name="payment_method" value="e_wallet_ovo">
                <label for="e_wallet_ovo"><img src="Assets/ovo.png" alt="OVO" class="h-5 w-auto inline-block mr-2"> OVO</label>
            </div>
            <div class="payment-method">
                <input type="radio" id="e_wallet_dana" name="payment_method" value="e_wallet_dana">
                <label for="e_wallet_dana"><img src="Assets/dana.png" alt="DANA" class="h-5 w-auto inline-block mr-2"> DANA</label>
            </div>
            <div class="payment-method">
                <input type="radio" id="cod" name="payment_method" value="cod">
                <label for="cod"><i class="fas fa-money-bill-wave mr-2"></i> Cash on Delivery (COD)</label>
            </div>
            <div class="error-message" id="payment-method-error">Please select a payment method</div>
        </div>

        <!-- Payment Summary Section -->
        <div class="section">
            <div class="payment-summary">
                <span class="summary-label">Subtotal</span>
                <span class="summary-amount" id="subtotal">Rp. 0</span>
            </div>
            <div class="payment-summary">
                <span class="summary-label">Shipping</span>
                <span class="summary-amount" id="shipping-cost">Rp. 10,000</span>
            </div>
            <div class="payment-summary" style="border-top: 1px solid #e0e0e0; padding-top: 10px; margin-top: 10px;">
                <span class="summary-label" style="font-size: 1.1rem;">Total</span>
                <span class="summary-amount" style="font-size: 1.1rem;" id="total-amount">Rp. 10,000</span>
            </div>
        </div>

        <button class="pay-button" id="pay-now-btn">Complete Order</button>
    </div>

    <footer class="bg-green-200 p-6 mt-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">About RecycleX</h3>
                <p class="text-green-800">
                    RecycleX is a marketplace platform that connects consumers with local UMKM (Micro, Small, and Medium Enterprises)
                    that produce recycled and sustainable products.
                </p>
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
                    <li class="flex items-center text-green-800">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Jl. Sustainable No. 123, Surabaya
                    </li>
                    <li class="flex items-center text-green-800">
                        <i class="fas fa-envelope mr-2"></i>
                        info@recyclex.id
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-green-300 mt-6 pt-6 text-center text-green-800">
            &copy; 2025 RecycleX. All rights reserved.
        </div>
    </footer>

    <script>
    // Global variables
    let originalSubtotal = 0;
    const shippingCost = 10000;

    function getCartDataFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const cartParam = urlParams.get('cart');

        if (cartParam) {
            try {
                return JSON.parse(decodeURIComponent(cartParam));
            } catch (e) {
                console.error("Error parsing cart data from URL", e);
                return [];
            }
        }

        const productId = urlParams.get('id');
        if (productId) {
            return [{
                id: productId,
                title: decodeURIComponent(urlParams.get('name') || ''),
                image: urlParams.get('image') || '',
                price: urlParams.get('price') || '0',
                quantity: parseInt(urlParams.get('quantity')) || 1
            }];
        }

        return [];
    }

    function formatNumber(number) {
        return number.toLocaleString('id-ID');
    }

    function updateTotalAmount() {
        const total = originalSubtotal + shippingCost;
        document.getElementById('total-amount').textContent = `Rp. ${formatNumber(total)}`;
    }

    function displayOrderDetails() {
        const orderItemsContainer = document.getElementById('order-items');
        const cartItems = getCartDataFromURL();
        let subtotal = 0;

        orderItemsContainer.innerHTML = '';

        if (cartItems.length > 0) {
            cartItems.forEach(item => {
                const productItem = document.createElement('div');
                productItem.classList.add('product-item');

                const priceString = item.price ? item.price.toString().replace(/[^0-9,-]/g, '') : '0';
                const price = parseFloat(priceString.replace(/\./g, '').replace(',', '.'));

                productItem.innerHTML = `
                    <img src="${item.image}" alt="${item.title}" class="product-image">
                    <div class="product-info">
                        <div class="product-name">${item.title}</div>
                        <div class="product-quantity">Quantity: ${item.quantity}</div>
                        <div class="product-price">Price: Rp. ${formatNumber(price)}</div>
                    </div>
                `;
                orderItemsContainer.appendChild(productItem);
                subtotal += price * item.quantity;
            });

            originalSubtotal = subtotal;
            document.getElementById('subtotal').textContent = `Rp. ${formatNumber(subtotal)}`;
            document.getElementById('shipping-cost').textContent = `Rp. ${formatNumber(shippingCost)}`;
            updateTotalAmount();
        } else {
            orderItemsContainer.innerHTML = '<p>No items in your cart.</p>';
            originalSubtotal = 0;
            document.getElementById('subtotal').textContent = 'Rp. 0';
            document.getElementById('shipping-cost').textContent = `Rp. ${formatNumber(shippingCost)}`;
            updateTotalAmount();
        }
    }

    // Form validation functions
    function validateForm() {
        let isValid = true;
        const errors = [];

        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');

        // Validate full name
        const fullName = document.getElementById('full-name').value.trim();
        if (!fullName) {
            document.getElementById('full-name-error').style.display = 'block';
            errors.push('Full name is required');
            isValid = false;
        }

        // Validate phone number
        const phoneNumber = document.getElementById('phone-number').value.trim();
        const phonePattern = /^(\+62|62|0)8[1-9][0-9]{6,10}$/;
        if (!phoneNumber) {
            document.getElementById('phone-number-error').textContent = 'Phone number is required';
            document.getElementById('phone-number-error').style.display = 'block';
            errors.push('Phone number is required');
            isValid = false;
        } else if (!phonePattern.test(phoneNumber)) {
            document.getElementById('phone-number-error').textContent = 'Please enter a valid Indonesian phone number';
            document.getElementById('phone-number-error').style.display = 'block';
            errors.push('Invalid phone number format');
            isValid = false;
        }

        // Validate street address
        const streetAddress = document.getElementById('street-address').value.trim();
        if (!streetAddress) {
            document.getElementById('street-address-error').style.display = 'block';
            errors.push('Street address is required');
            isValid = false;
        }

        // Validate city
        const city = document.getElementById('city').value.trim();
        if (!city) {
            document.getElementById('city-error').style.display = 'block';
            errors.push('City is required');
            isValid = false;
        }

        // Validate postal code
        const postalCode = document.getElementById('postal-code').value.trim();
        const postalPattern = /^[0-9]{5}$/;
        if (!postalCode) {
            document.getElementById('postal-code-error').textContent = 'Postal code is required';
            document.getElementById('postal-code-error').style.display = 'block';
            errors.push('Postal code is required');
            isValid = false;
        } else if (!postalPattern.test(postalCode)) {
            document.getElementById('postal-code-error').textContent = 'Please enter a valid 5-digit postal code';
            document.getElementById('postal-code-error').style.display = 'block';
            errors.push('Invalid postal code format');
            isValid = false;
        }

        // Validate province
        const province = document.getElementById('province').value;
        if (!province) {
            document.getElementById('province-error').style.display = 'block';
            errors.push('Province is required');
            isValid = false;
        }

        // Validate payment method
        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!selectedPaymentMethod) {
            document.getElementById('payment-method-error').style.display = 'block';
            errors.push('Payment method is required');
            isValid = false;
        }

        return isValid;
    }

    function collectFormData() {
        return {
            shipping: {
                fullName: document.getElementById('full-name').value.trim(),
                phoneNumber: document.getElementById('phone-number').value.trim(),
                streetAddress: document.getElementById('street-address').value.trim(),
                city: document.getElementById('city').value.trim(),
                postalCode: document.getElementById('postal-code').value.trim(),
                province: document.getElementById('province').value,
                deliveryNotes: document.getElementById('delivery-notes').value.trim()
            },
            paymentMethod: document.querySelector('input[name="payment_method"]:checked')?.value,
            order: {
                items: getCartDataFromURL(),
                subtotal: document.getElementById('subtotal').textContent,
                shipping: document.getElementById('shipping-cost').textContent,
                total: document.getElementById('total-amount').textContent
            }
        };
    }

    // Function to generate unique order ID
    function generateOrderId() {
        const timestamp = Date.now();
        const random = Math.floor(Math.random() * 1000);
        return `ORD-${timestamp}-${random}`;
    }

    // Function to get payment method display name
    function getPaymentMethodDisplayName(paymentMethod) {
        const paymentNames = {
            'bank_transfer': 'Bank Transfer',
            'credit_card': 'Credit Card',
            'e_wallet_gopay': 'GoPay',
            'e_wallet_ovo': 'OVO',
            'e_wallet_dana': 'DANA',
            'cod': 'Cash on Delivery'
        };
        return paymentNames[paymentMethod] || paymentMethod;
    }

    // Function to save order to localStorage (FIXED)
    function saveOrderToStorage(orderData) {
        const cartItems = orderData.order.items;
        
        // Create order objects for each item
        const orders = cartItems.map(item => {
            const orderId = generateOrderId();
            const currentDate = new Date();
            
            // Fixed the price formatting - removed extra closing brace
            const priceString = item.price ? item.price.toString().replace(/[^0-9,-]/g, '') : '0';
            const price = parseFloat(priceString.replace(/\./g, '').replace(',', '.'));
            
            return {
                orderId: orderId,
                merchant: "RecycleX Store", // Default merchant name
                name: item.title,
                description1: `Quantity: ${item.quantity}`,
                description2: `Payment: ${getPaymentMethodDisplayName(orderData.paymentMethod)}`,
                price: `Rp. ${formatNumber(price)}`, // Fixed: removed extra closing brace
                image: item.image,
                status: "PACKED",
                statusInfo: `Order placed on ${currentDate.toLocaleDateString('id-ID')} - Being prepared for shipment`,
                total: orderData.order.total,
                orderDate: currentDate.toISOString(),
                shipping: orderData.shipping,
                paymentMethod: orderData.paymentMethod
            };
        });

        // Get existing orders from localStorage
        const existingOrders = JSON.parse(localStorage.getItem('paidOrders') || '[]');
        
        // Add new orders
        const updatedOrders = [...existingOrders, ...orders];
        
        // Save to localStorage
        localStorage.setItem('paidOrders', JSON.stringify(updatedOrders));
        
        console.log('Orders saved to localStorage:', orders);
        return orders;
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        displayOrderDetails();

        // Payment method selection
        const paymentMethods = document.querySelectorAll('.payment-method');
        paymentMethods.forEach(method => {
            method.addEventListener('click', () => {
                paymentMethods.forEach(m => m.classList.remove('selected'));
                method.classList.add('selected');
                const radioInput = method.querySelector('input[type="radio"]');
                if (radioInput) {
                    radioInput.checked = true;
                    // Hide payment method error if one is selected
                    document.getElementById('payment-method-error').style.display = 'none';
                }
            });
        });

        // Real-time validation
        const requiredFields = ['full-name', 'phone-number', 'street-address', 'city', 'postal-code', 'province'];
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', () => {
                    if (field.value.trim()) {
                        document.getElementById(fieldId + '-error').style.display = 'none';
                    }
                });
            }
        });

        // Pay button event listener
        document.getElementById('pay-now-btn').addEventListener('click', function() {
            if (validateForm()) {
                const orderData = collectFormData();
                
                // Show confirmation
                const confirmMessage = `Confirm your order:\n\nShip to: ${orderData.shipping.fullName}\nAddress: ${orderData.shipping.streetAddress}, ${orderData.shipping.city}\nPayment: ${getPaymentMethodDisplayName(orderData.paymentMethod)}\nTotal: ${orderData.order.total}\n\nProceed with payment?`;
                
                if (confirm(confirmMessage)) {
                    // Save order to localStorage
                    const savedOrders = saveOrderToStorage(orderData);
                    
                    // Clear cart (if using localStorage)
                    if (typeof(Storage) !== "undefined") {
                        localStorage.removeItem('cartItems');
                        localStorage.setItem('cartCount', '0');
                    }
                    
                    console.log('Payment successful! Orders saved:', savedOrders);
                    alert('Payment successful! Thank you for your purchase. You can view your order in My Orders page.');
                    
                    // Redirect to my order page
                    window.location.href = "myorderpage"; 
                }
            } else {
                alert('Please fill in all required fields correctly.');
            }
        });
    });
    </script>
</body>
</html>