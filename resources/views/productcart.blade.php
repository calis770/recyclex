<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- IMPORTANT: Keep this for CSRF token --}}
    <title>RecycleX - Product Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .quantity-btn {
            cursor: pointer;
            user-select: none;
        }
        .quantity-btn:hover {
            background-color: #e5e7eb;
        }
        .cart-icon-container {
            position: relative;
        }
        .cart-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }
        /* Style for disabled checkout button */
        #checkout-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <header class="bg-green-200 p-4 flex justify-between items-center">
        <div class="flex items-center">
            <a href="{{ route('homepage') }}" class="flex items-center hover:opacity-80 transition-opacity">
                <img alt="RecycleX logo" class="h-12 w-12" height="50" src="{{ asset('Assets/logo.png') }}" width="50"/>
                <div class="ml-2">
                    <span class="text-sm text-green-700">
                        Download RecycleX App
                    </span>
                    <h1 class="text-3xl font-bold text-green-700">
                        RecycleX
                    </h1>
                </div>
            </a>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text"/>
                <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
            </div>
            <a href="{{ route('productcart') }}" class="cart-icon-container">
                <i class="fas fa-shopping-cart text-green-700 text-2xl"></i>
                <span id="cartBadge" class="cart-badge">0</span>
            </a>
            <a href="{{ route('profilepage') }}" class="flex items-center">
                <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto my-6 px-4">
        <section class="bg-white p-6 rounded-lg shadow-md mb-4">
            <h2 class="text-2xl font-bold text-green-800 mb-6">
                Product Cart
            </h2>
            
            <div id="empty-cart-message" class="py-8 text-center text-gray-500" style="display: none;">
                Your cart is empty. Start shopping to add items to your cart.
                <div class="mt-4">
                    <a href="{{ route('homepage') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg">
                        Continue Shopping
                    </a>
                </div>
            </div>
            
            <div id="cart-items-container" style="display: none;">
                <div class="py-3 border-b">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" id="store-checkbox" class="mr-2 form-checkbox h-5 w-5 text-green-600" checked>
                        <span class="font-medium">Select All</span>
                    </label>
                </div>
                
                <div id="cart-items">
                    </div>
            </div>
            
            <div id="cart-total" class="mt-6 py-4 border-t" style="display: none;">
                <div class="flex justify-between">
                    <span class="font-medium text-gray-700">Total:</span>
                    <span id="total-price" class="font-bold text-green-800">Rp 0</span>
                </div>
                <div class="mt-4 flex justify-end">
                    <button id="checkout-button" class="bg-green-700 text-white px-6 py-2 rounded-lg">
                        Checkout
                    </button>
                </div>
            </div>
        </section>
        
        <section class="bg-white p-4 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-green-800 mr-2">
                        <i class="fas fa-ticket-alt"></i>
                    </span>
                    <span class="text-gray-700">Tersedia Diskon s/d 50%</span>
                </div>
                <a href="{{ route('rewardspage') }}" class="text-green-800 hover:underline">Koleksi Koin</a>
            </div>
        </section>
    </main>
    
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
        document.addEventListener('DOMContentLoaded', function() {
            const cartBadge = document.getElementById('cartBadge');
            const cartItemsContainer = document.getElementById('cart-items-container');
            const cartItemsDiv = document.getElementById('cart-items');
            const emptyCartMessage = document.getElementById('empty-cart-message');
            const cartTotalSection = document.getElementById('cart-total');
            const totalPriceElement = document.getElementById('total-price');
            const storeCheckbox = document.getElementById('store-checkbox');
            const checkoutButton = document.getElementById('checkout-button');
            
            // Get cart data from localStorage
            let cartCount = localStorage.getItem('cartCount') ? parseInt(localStorage.getItem('cartCount')) : 0;
            let items = [];

            try {
                items = localStorage.getItem('cartItems') ? JSON.parse(localStorage.getItem('cartItems')) : [];
            } catch (e) {
                console.error("Error parsing cart items from localStorage", e);
                items = [];
            }
            
            // Update cart badge
            cartBadge.textContent = cartCount;
            
            // Handle empty cart display
            if (items.length === 0) {
                cartItemsContainer.style.display = 'none';
                emptyCartMessage.style.display = 'block';
                cartTotalSection.style.display = 'none';
            } else {
                cartItemsContainer.style.display = 'block';
                emptyCartMessage.style.display = 'none';
                cartTotalSection.style.display = 'block';
                
                renderCartItems(items);
                updateTotal();
            }
            
            function parsePrice(priceString) {
                if (typeof priceString === 'number') return priceString;
                if (!priceString) return 0;
                
                const cleanPrice = priceString.toString().replace(/[^\d,]/g, '').replace(',', '.');
                const parsed = parseFloat(cleanPrice);
                return isNaN(parsed) ? 0 : parsed;
            }
            
            function renderCartItems(currentItems) {
                cartItemsDiv.innerHTML = '';
                
                currentItems.forEach((item, index) => {
                    // Ensure product_id exists and is valid
                    const productId = item.product_id || item.id; // Prioritize product_id, fallback to id

                    const itemElement = document.createElement('div');
                    itemElement.className = 'py-6 flex items-center border-b';
                    itemElement.innerHTML = `
                        <input type="checkbox" class="mr-4 form-checkbox h-5 w-5 text-green-600 item-checkbox" data-index="${index}" ${item.checked ? 'checked' : ''}>
                        
                        <div class="flex flex-1 items-start">
                            <img src="${item.image || '/Assets/placeholder-image.jpg'}" alt="${item.title}" class="w-28 h-28 object-cover rounded-lg mr-6">
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-gray-800">${item.title}</h3>
                                <p class="text-gray-600">${item.description || ''}</p>
                                <p class="text-gray-600">Variasi: ${item.variant || 'Tidak ada'}</p>
                                <p class="text-green-800 font-bold mt-2 item-price" data-price="${item.price || '0'}">${formatCurrency(item.price || '0')}</p>
                            </div>
                            
                            <div class="flex items-center border border-gray-300 rounded">
                                <button class="quantity-btn decrement-btn w-8 h-8 flex items-center justify-center bg-gray-100 rounded-l" data-index="${index}">
                                    <span class="text-gray-600 font-medium">-</span>
                                </button>
                                <input type="text" value="${item.quantity}" class="quantity-input h-8 w-12 border-l border-r border-gray-300 text-center" data-index="${index}" readonly>
                                <button class="quantity-btn increment-btn w-8 h-8 flex items-center justify-center bg-gray-100 rounded-r" data-index="${index}">
                                    <span class="text-gray-600 font-medium">+</span>
                                </button>
                            </div>
                            
                            <button class="ml-4 text-red-500 remove-item-btn" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                    
                    cartItemsDiv.appendChild(itemElement);
                });
                
                // Add event listeners for quantity buttons
                document.querySelectorAll('.decrement-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        if (items[index].quantity > 1) {
                            items[index].quantity--;
                            this.nextElementSibling.value = items[index].quantity;
                            updateLocalStorage();
                            updateTotal();
                        }
                    });
                });
                
                document.querySelectorAll('.increment-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        items[index].quantity++;
                        this.previousElementSibling.value = items[index].quantity;
                        updateLocalStorage();
                        updateTotal();
                    });
                });
                
                // Add event listeners for individual item checkboxes
                document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        items[index].checked = this.checked;
                        updateLocalStorage();
                        updateTotal();
                        if (!this.checked) {
                            storeCheckbox.checked = false;
                        } else {
                            const allItemsChecked = Array.from(document.querySelectorAll('.item-checkbox')).every(cb => cb.checked);
                            if (allItemsChecked) {
                                storeCheckbox.checked = true;
                            }
                        }
                    });
                });
                
                // Add event listeners for remove buttons
                document.querySelectorAll('.remove-item-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const index = parseInt(this.getAttribute('data-index'));
                        const quantityRemoved = items[index].quantity;
                        
                        cartCount -= quantityRemoved;
                        if (cartCount < 0) cartCount = 0;
                        cartBadge.textContent = cartCount;
                        
                        items.splice(index, 1);
                        updateLocalStorage();
                        
                        if (items.length === 0) {
                            cartItemsContainer.style.display = 'none';
                            emptyCartMessage.style.display = 'block';
                            cartTotalSection.style.display = 'none';
                        } else {
                            renderCartItems(items); // Re-render to update indices
                            updateTotal();
                        }
                    });
                });
            }
            
            // Add event listener for store checkbox (select all/deselect all)
            storeCheckbox.addEventListener('change', function() {
                document.querySelectorAll('.item-checkbox').forEach(checkbox => {
                    checkbox.checked = this.checked;
                    const index = parseInt(checkbox.getAttribute('data-index'));
                    items[index].checked = this.checked;
                });
                
                updateLocalStorage();
                updateTotal();
            });
            
            function formatCurrency(value) {
                if (typeof value === 'string' && value.startsWith('Rp')) {
                    return value;
                }
                
                const num = parsePrice(value);
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(num);
            }
            
            function updateTotal() {
                let total = 0;
                items.forEach(item => {
                    if (item.checked) {
                        const price = parsePrice(item.price);
                        const quantity = item.quantity;
                        total += price * quantity;
                    }
                });
                
                totalPriceElement.textContent = formatCurrency(total);
                // Disable checkout button if total is 0 or no items checked
                checkoutButton.disabled = total === 0;
            }
            
            function updateLocalStorage() {
                localStorage.setItem('cartItems', JSON.stringify(items));
                localStorage.setItem('cartCount', cartCount);
            }
            
            checkoutButton.addEventListener('click', function () {
                const selectedItems = [];
                let currentTotal = 0;

                items.forEach(item => {
                    if (item.checked) {
                        // --- Validate product_id here ---
                        const productId = item.product_id || item.id; // Use item.id if that's what you saved from product page
                        if (!productId || productId.trim() === '') {
                            alert('Data keranjang tidak lengkap: Ada item yang dipilih tanpa ID produk. Harap hapus dan tambahkan ulang item tersebut.');
                            console.error('Item tanpa product_id:', item);
                            return; // Stop the checkout process
                        }

                        const price = parsePrice(item.price);
                        const quantity = item.quantity;
                        const itemTotal = price * quantity;
                        currentTotal += itemTotal;

                        selectedItems.push({
                            id: productId, // Using 'id' as the key to align with common data structures
                            name: item.title, // 'name' for payment page display
                            price: price,
                            quantity: quantity,
                            image: item.image || '',
                            variation: item.variant || 'Default', // 'variation' for payment page display
                        });
                    }
                });

                if (selectedItems.length === 0) {
                    alert('Pilih minimal satu produk untuk checkout.');
                    return;
                }
                
                // If any item lacked product_id and the loop returned, selectedItems might be incomplete.
                // This check serves as a final safeguard before proceeding.
                if (selectedItems.some(item => !item.id || item.id.trim() === '')) {
                    alert('Checkout dibatalkan karena ada item yang tidak lengkap.');
                    return;
                }

                const checkoutData = {
                    items: selectedItems,
                    payment_summary: {
                        subtotal: currentTotal,
                        shipping: 15000, // Example fixed shipping cost, adjust as needed
                        total: currentTotal + 15000 
                    }
                };

                // Store checkout data in sessionStorage as the payment page expects it from there
                sessionStorage.setItem('checkoutData', JSON.stringify(checkoutData));

                // --- Submit a POST form to trigger the Laravel route ---
                const form = document.createElement('form');
                form.method = 'POST';
                // Use the route helper directly here
                form.action = '{{ route("paymentpage.cart.checkout") }}'; 
                form.style.display = 'none';

                // CSRF token input
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                form.appendChild(csrfInput);

                // Add a dummy input if needed, or if your backend specifically expects a 'checkout_data' field
                // However, the actual detailed data for the frontend display on payment page is in sessionStorage now.
                // The POST request itself might just be a trigger for the backend.
                const dummyInput = document.createElement('input');
                dummyInput.type = 'hidden';
                dummyInput.name = 'status'; // Or any minimal data your backend might require for this POST
                dummyInput.value = 'checkout_initiated'; 
                form.appendChild(dummyInput);


                document.body.appendChild(form);
                form.submit(); // This will submit the form as a POST request
            });
        });
    </script>
</body>
</html>