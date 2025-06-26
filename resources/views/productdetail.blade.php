<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>RecycleX - {{ $product->product_name ?? 'Product Detail' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
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
        .hidden {
            display: none !important;
        }
        .cart-animation {
            animation: bounce-cart 0.5s ease-in-out;
        }
        @keyframes bounce-cart {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
        .variation-selected {
            border-color: #2b5329 !important;
            border-width: 2px !important;
            background-color: #f0f9f0;
        }

        /* Custom style for smaller "Rp." and aligning price */
        .price-wrapper {
            display: flex;
            align-items: baseline;
        }
        .price-rp {
            font-size: 0.7em;
            vertical-align: baseline;
            margin-right: 2px;
        }
        .price-number {
            font-size: 0.7em;
            line-height: 1;
        }
        /* Adjust alignment for quantity input text */
        #quantity {
            text-align: center;
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <header class="bg-green-200 p-4 flex justify-between items-center">
      <div class="flex items-center">
        <a href="{{ route('homepage') }}" class="flex items-center hover:opacity-80 transition-opacity">
        <img alt="RecycleX logo" class="h-12 w-12" height="50" src="{{ asset('Assets/logo.png') }}" width="50"/>
        </a>
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
        <input id="searchInput" class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text"/>
        <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
        <div id="searchResults" class="search-results"></div>
        </div>
        <a href="{{ route('productcart') }}" class="fas fa-shopping-cart text-green-700 text-2xl"></a>
        
        <div class="profile-dropdown">
            <div class="profile-button flex items-center" onclick="toggleDropdown()">
                <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
                <i class="fas fa-chevron-down text-green-700 ml-2 text-sm"></i>
            </div>
            <div id="profileDropdown" class="dropdown-content">
                <a href="{{ route('profilepage') }}">
                    <i class="fas fa-user mr-2"></i>Profile
                </a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
                {{-- Form logout untuk Laravel --}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
      </div>
    </header>

    <main class="p-4 max-w-5xl mx-auto"> 
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-green-800 mb-4 border-b pb-3">Detail Produk</h2>
            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex-shrink-0">
                    <img alt="{{ $product->product_name }}" 
                             class="w-full md:w-[300px] h-[300px] object-cover rounded-lg shadow-md" 
                             src="{{ asset('storage/' . $product->image_product)}}"/>
                </div>
                <div class="flex-1">
                    <h3 id="detail-product-name" class="text-2xl font-bold text-gray-900 mb-1.5">{{ $product->product_name }}</h3>
                    <p id="detail-product-description" class="text-gray-700 mb-3 leading-relaxed text-sm">{{ $product->description ?? 'Deskripsi produk tidak tersedia.' }}</p>
                    
                    @if($product->rating || $product->reviews_count || $product->sold_count)
                    <div class="flex items-center mb-3 text-gray-600 text-sm">
                        @if($product->rating)
                            <span id="detail-product-rating" class="text-lg font-bold text-yellow-500 mr-1">{{ number_format($product->rating, 1) }}</span>
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                        @endif
                        @if($product->reviews_count)
                            <span id="detail-product-reviews" class="mr-2">{{ $product->reviews_count }} Penilaian</span>
                        @endif
                        @if($product->sold_count)
                            <span id="detail-product-sold">{{ $product->sold_count }} Terjual</span>
                        @endif
                    </div>
                    @endif

                    <p id="detail-product-price" class="text-red-600 text-3xl font-extrabold mb-4 price-wrapper" data-base-price="{{ $product->price }}">
                        <span class="price-rp">Rp.</span> <span class="price-number">{{ number_format($product->price, 0, ',', '.') }}</span>
                    </p>
                    
                    @if($product->store_name || $product->seller_name)
                    <div class="flex items-center mb-4 p-3 bg-green-50 rounded-lg border border-green-200">
                        <i class="fas fa-store text-green-700 text-xl mr-3"></i>
                        <div>
                            <p class="text-xs text-gray-600">Dijual oleh:</p>
                            <p class="text-green-700 font-bold text-base">{{ $product->store_name ?? $product->seller_name ?? 'Toko Tidak Diketahui' }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="flex items-center mb-4 p-2 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-truck text-gray-700 text-lg mr-2.5"></i>
                        <div>
                            <p class="text-gray-700 text-xs">Pengiriman ke</p>
                            <p class="text-gray-900 font-semibold text-sm">KOTA SURABAYA</p>
                            <p class="text-gray-700 text-xs">{{ $product->shipping_cost ? 'Rp. ' . number_format($product->shipping_cost, 0, ',', '.') : 'Gratis' }}</p>
                        </div>
                    </div>

                    {{-- --- Perubahan di sini: Menggunakan $product->variasi (string) --- --}}
                    @if($product->variasi)
                    <div class="mb-4">
                        <p class="text-gray-700 font-semibold mb-2 text-sm">Variasi Produk:</p>
                        <div id="detail-product-variations" class="flex flex-wrap gap-2">
                            @php
                                // Memisahkan string variasi menjadi array
                                // Contoh: "Merah, Biru, Hijau" akan menjadi ["Merah", "Biru", "Hijau"]
                                $variationsArray = explode(',', $product->variasi);
                                // Menghapus spasi ekstra dari setiap item
                                $variationsArray = array_map('trim', $variationsArray);
                            @endphp

                            @foreach($variationsArray as $index => $variationName)
                                @if(!empty($variationName)) {{-- Pastikan bukan string kosong --}}
                                <button type="button" class="border border-gray-300 px-3 py-1.5 rounded-full flex items-center justify-center text-xs transition-all duration-200 ease-in-out {{ $index === 0 ? 'variation-selected' : '' }}"
                                        data-variation-name="{{ $variationName }}"
                                        data-variation-price-adjustment="0" {{-- Disetel 0 karena tidak ada penyesuaian harga --}}
                                        data-variation-id="{{ $index }}"> {{-- Menggunakan index sebagai ID sementara --}}
                                    <span>{{ $variationName }}</span>
                                </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                    {{-- --- Akhir Perubahan Variasi --- --}}

                    <div class="flex items-center mb-5">
                        <p class="text-gray-700 font-semibold mr-3 text-base">Jumlah</p>
                        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
                            <button type="button" id="decreaseQty" class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-lg font-bold">-</button>
                            <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock ?? 999 }}" class="w-14 text-center border-l border-r border-gray-300 py-1.5 text-lg focus:outline-none"/>
                            <button type="button" id="increaseQty" class="px-3 py-1.5 text-gray-600 hover:bg-gray-100 transition-colors duration-200 text-lg font-bold">+</button>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <button id="addToCartBtn" class="bg-green-600 text-white px-6 py-2.5 rounded-lg hover:bg-green-700 transition-colors duration-300 flex items-center justify-center text-base font-semibold shadow-md">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Tambah ke Keranjang
                        </button>
                        <button id="buyNowBtn" class="bg-red-600 text-white px-6 py-2.5 rounded-lg hover:bg-red-700 transition-colors duration-300 text-base font-semibold shadow-md">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if($product->reviews && count($product->reviews) > 0)
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-xl font-bold text-green-800 mb-4 border-b pb-3">Ulasan Pembeli</h3>
            <div class="space-y-5">
                @foreach($product->reviews as $review)
                <div class="flex items-start border-b border-gray-200 pb-5 last:border-b-0 last:pb-0">
                    <img src="{{ $review['user_avatar'] ?? 'https://via.placeholder.com/40x40/4ade80/ffffff?text=' . substr($review['user_name'], 0, 1) }}" 
                             alt="User Avatar" class="w-10 h-10 rounded-full mr-3 object-cover shadow-sm">
                    <div class="flex-1">
                        <div class="flex items-center mb-1">
                            <span class="font-semibold text-gray-900 text-base mr-2">{{ $review['user_name'] }}</span>
                            <div class="flex text-yellow-500 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review['rating'])
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="text-gray-700 leading-relaxed text-sm mb-1">{{ $review['comment'] }}</p>
                        <p class="text-gray-500 text-xs">{{ $review['created_at'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @if(count($product->reviews) > 3)
                <button class="mt-4 text-green-700 font-semibold hover:underline text-sm">Lihat semua ulasan</button>
            @endif
        </div>
        @endif
    </main>

    {{-- Hidden form for Buy Now --}}
    <form id="buyNowForm" action="{{ route('paymentpage.buynow') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
        <input type="hidden" name="quantity" id="buyNowQuantity">
        <input type="hidden" name="variation_id" id="buyNowVariationId">
        <input type="hidden" name="product_name" value="{{ $product->product_name }}">
        <input type="hidden" name="product_price" id="buyNowProductPrice">
        <input type="hidden" name="image_product" value="{{ $product->image_product }}">
    </form>

    <script>
        // Cart functionality
let cartCount = {{ session('cart_count', 0) }};
const basePrice = {{ $product->price }};
let currentPriceAdjustment = 0;

function toggleDropdown() {
    document.getElementById("profileDropdown").classList.toggle("show");
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.profile-button') && !event.target.closest('.profile-button')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

// Variation selection
document.querySelectorAll('[data-variation-name]').forEach(button => {
    button.addEventListener('click', function() {
        // Hapus seleksi dari semua variasi
        document.querySelectorAll('[data-variation-name]').forEach(btn => {
            btn.classList.remove('variation-selected');
        });
        
        // Tambahkan seleksi ke variasi yang diklik
        this.classList.add('variation-selected');
    });
});

// Quantity controls
document.getElementById('decreaseQty').addEventListener('click', function() {
    const qtyInput = document.getElementById('quantity');
    let currentQty = parseInt(qtyInput.value);
    if (currentQty > 1) {
        qtyInput.value = currentQty - 1;
    }
});

document.getElementById('increaseQty').addEventListener('click', function() {
    const qtyInput = document.getElementById('quantity');
    let currentQty = parseInt(qtyInput.value);
    const maxStock = parseInt(qtyInput.getAttribute('max'));
    if (currentQty < maxStock) {
        qtyInput.value = currentQty + 1;
    }
});

function updatePrice() {
    const newPrice = basePrice + currentPriceAdjustment;
    document.getElementById('detail-product-price').innerHTML = `<span class="price-rp">Rp.</span> <span class="price-number">${newPrice.toLocaleString('id-ID')}</span>`;
}

// Function to get current cart from localStorage
function getCurrentCart() {
    try {
        return JSON.parse(localStorage.getItem('cartItems')) || [];
    } catch (e) {
        console.error('Error parsing cart items:', e);
        return [];
    }
}

// Function to save cart to localStorage
function saveCartToLocalStorage(cartItems) {
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    localStorage.setItem('cartCount', cartItems.reduce((total, item) => total + item.quantity, 0));
}

// Function to update cart badge
function updateCartBadge() {
    const cartItems = getCurrentCart();
    const totalItems = cartItems.reduce((total, item) => total + item.quantity, 0);
    const cartBadge = document.querySelector('.fa-shopping-cart').parentElement.querySelector('.cart-badge');
    if (cartBadge) {
        cartBadge.textContent = totalItems;
    }
}

// Add to cart functionality - Updated Version
document.getElementById('addToCartBtn').addEventListener('click', function() {
    const quantity = parseInt(document.getElementById('quantity').value);
    const selectedVariation = document.querySelector('.variation-selected');
    const variationName = selectedVariation ? selectedVariation.dataset.variationName : 'Default';
    
    // Get product details from the page
    const productData = {
        id: '{{ $product->product_id }}',
        title: document.getElementById('detail-product-name').textContent,
        description: document.getElementById('detail-product-description').textContent,
        price: basePrice,
        image: '{{ asset("storage/" . $product->image_product) }}',
        variant: variationName,
        quantity: quantity,
        store_name: '{{ $product->store_name ?? $product->seller_name ?? "Toko Tidak Diketahui" }}'
    };

    // Get current cart items
    let cartItems = getCurrentCart();
    
    // Check if item already exists in cart
    const existingItemIndex = cartItems.findIndex(item => 
        item.id === productData.id && item.variant === productData.variant
    );
    
    if (existingItemIndex !== -1) {
        // Update quantity if item exists
        cartItems[existingItemIndex].quantity += quantity;
    } else {
        // Add new item to cart
        cartItems.push(productData);
    }
    
    // Save to localStorage
    saveCartToLocalStorage(cartItems);
    
    // Update cart badge
    updateCartBadge();
    
    // Show success animation and message
    const cartIcon = document.querySelector('.fa-shopping-cart');
    cartIcon.classList.add('cart-animation');
    setTimeout(() => {
        cartIcon.classList.remove('cart-animation');
    }, 500);
    
    // Show success notification
    showNotification('Produk ' + (variationName !== 'Default' ? '(' + variationName + ') ' : '') + 'berhasil ditambahkan ke keranjang!', 'success');
    
    // Optional: Send to backend as well
    sendToBackend(productData);
});

// Function to show notification
function showNotification(message, type = 'success') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Function to send cart data to backend (optional - for database persistence)
function sendToBackend(productData) {
    fetch('{{ route("carts.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productData.id,
            quantity: productData.quantity,
            variation: productData.variant
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Item successfully added to database cart');
        } else {
            console.error('Failed to add item to database cart:', data.message);
        }
    })
    .catch(error => {
        console.error('Error sending to backend:', error);
    });
}

// Buy now functionality
document.getElementById('buyNowBtn').addEventListener('click', function() {
    const quantity = document.getElementById('quantity').value;
    const selectedVariation = document.querySelector('.variation-selected');
    const variationId = selectedVariation ? selectedVariation.dataset.variationId : null;
    const currentDisplayedPrice = basePrice;
    
    // Fill hidden form fields
    document.getElementById('buyNowQuantity').value = quantity;
    document.getElementById('buyNowVariationId').value = variationId;
    document.getElementById('buyNowProductPrice').value = currentDisplayedPrice;

    // Submit form
    document.getElementById('buyNowForm').submit();
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.trim();
    const resultsDiv = document.getElementById('searchResults');
    
    if (query.length > 2) {
        resultsDiv.innerHTML = '<div class="search-result-item">Searching...</div>';
        resultsDiv.style.display = 'block';
    } else {
        resultsDiv.style.display = 'none';
    }
});

// Hide search results when clicking outside
document.addEventListener('click', function(event) {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    
    if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
        searchResults.style.display = 'none';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePrice();
    updateCartBadge();
    
    // Auto-select first variation if available
    const firstVariationButton = document.querySelector('#detail-product-variations button');
    if (firstVariationButton) {
        firstVariationButton.click();
    }
});
    </script>
</body>
</html>