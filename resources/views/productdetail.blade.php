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
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <header class="bg-green-200 p-4 flex justify-between items-center">
      <div class="flex items-center">
        <img alt="RecycleX logo" class="h-12 w-12" height="50" src="{{ asset('Assets/logo.png') }}" width="50"/>
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

    <main class="p-4">
        <!-- Display success/error messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Breadcrumbs -->
        <div class="text-gray-600 text-sm mb-4">
            <a href="{{ route('home') }}" class="hover:underline">Home</a> &gt;
            <a href="{{ route('products.index') }}" class="hover:underline">Produk</a> &gt;
            <span class="font-semibold">{{ $product->product_name }}</span>
        </div>

        <div class="productdetail">
            <div class="main-content">
                <div class="content-area">
                    <h2 class="text-2xl font-bold text-green-700 mb-4">Detail Produk</h2>
                    <div class="bg-white rounded-lg p-6">
                        <div class="flex flex-col md:flex-row">
                            <img alt="{{ $product->product_name }}" 
                                 class="w-full md:w-96 h-96 object-cover rounded-lg mb-4 md:mb-0 md:mr-6" 
                                 src="{{ asset('storage/' . $product->image_product) }}"/>
                            <div class="flex-1">
                                <h3 id="detail-product-name" class="text-2xl font-bold mb-2">{{ $product->product_name }}</h3>
                                <p id="detail-product-description" class="text-gray-700 mb-2">{{ $product->description ?? 'Deskripsi produk tidak tersedia.' }}</p>
                                
                                @if($product->rating || $product->reviews_count)
                                <div class="flex items-center mb-4">
                                    @if($product->rating)
                                        <span id="detail-product-rating" class="text-lg font-bold text-yellow-500">{{ number_format($product->rating, 1) }}</span>
                                        <i class="fas fa-star text-yellow-500 ml-1"></i>
                                    @endif
                                    @if($product->reviews_count)
                                        <span id="detail-product-reviews" class="text-gray-700 ml-2">{{ $product->reviews_count }} Penilaian</span>
                                    @endif
                                    @if($product->sold_count)
                                        <span id="detail-product-sold" class="text-gray-700 ml-4">{{ $product->sold_count }} Terjual</span>
                                    @endif
                                </div>
                                @endif

                                <p id="detail-product-price" class="text-red-600 text-xl font-bold mb-4" data-base-price="{{ $product->price }}">
                                    Rp. {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                
                                <!-- UMKM Information -->
                                @if($product->store_name || $product->seller_name)
                                <div class="flex items-center mb-4 p-3 bg-green-50 rounded-lg">
                                    <i class="fas fa-store text-green-700 text-xl mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Dijual oleh:</p>
                                        <p class="text-green-700 font-bold">{{ $product->store_name ?? $product->seller_name ?? 'Toko Tidak Diketahui' }}</p>
                                    </div>
                                </div>
                                @endif

                                <div class="flex items-center mb-4">
                                    <i class="fas fa-truck text-gray-700 text-2xl mr-2"></i>
                                    <div>
                                        <p class="text-gray-700">Pengiriman ke</p>
                                        <p class="text-gray-700 font-bold">KOTA SURABAYA</p>
                                        <p class="text-gray-700">{{ $product->shipping_cost ? 'Rp. ' . number_format($product->shipping_cost, 0, ',', '.') : 'Gratis' }}</p>
                                    </div>
                                </div>

                                <!-- Variations Section (if product has variations) -->
                                @if($product->variations && count($product->variations) > 0)
                                <div class="mb-4">
                                    <p class="text-gray-700 mb-2">Variasi Produk</p>
                                    <div id="detail-product-variations" class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach($product->variations as $index => $variation)
                                        <button type="button" class="border border-gray-300 p-2 rounded-lg flex items-center justify-center text-sm {{ $index === 0 ? 'variation-selected' : '' }}"
                                                data-variation-name="{{ $variation['name'] }}"
                                                data-variation-price-adjustment="{{ $variation['price_adjustment'] ?? 0 }}">
                                            @if(isset($variation['color']))
                                                <div class="w-5 h-5 rounded mr-2" style="background-color: {{ $variation['color'] }}"></div>
                                            @endif
                                            <span>{{ $variation['name'] }}</span>
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Quantity Section -->
                                <div class="flex items-center mb-4">
                                    <p class="text-gray-700 mr-4">Jumlah</p>
                                    <div class="flex items-center border border-gray-300 rounded-lg">
                                        <button type="button" id="decreaseQty" class="px-3 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock ?? 999 }}" class="w-16 text-center border-none outline-none"/>
                                        <button type="button" id="increaseQty" class="px-3 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                    </div>
                                    <span class="text-gray-500 ml-4">Stok: {{ $product->stock ?? 'Tidak terbatas' }}</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex space-x-4">
                                    <button id="addToCartBtn" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Tambah ke Keranjang
                                    </button>
                                    <button id="buyNowBtn" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors">
                                        Beli Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    <div class="bg-white rounded-lg p-6 mt-6">
                        <h3 class="text-xl font-bold text-green-700 mb-4">Deskripsi Produk</h3>
                        <div class="text-gray-700 space-y-3">
                            @if($product->long_description)
                                {!! nl2br(e($product->long_description)) !!}
                            @else
                                <p>{{ $product->description ?? 'Deskripsi detail tidak tersedia untuk produk ini.' }}</p>
                            @endif

                            @if($product->specifications)
                                <div class="mt-4">
                                    <p><strong>Spesifikasi:</strong></p>
                                    <div class="ml-4">
                                        {!! nl2br(e($product->specifications)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    @if($product->reviews && count($product->reviews) > 0)
                    <div class="bg-white rounded-lg p-6 mt-6">
                        <h3 class="text-xl font-bold text-green-700 mb-4">Ulasan Pembeli</h3>
                        <div class="space-y-4">
                            @foreach($product->reviews as $review)
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex items-start">
                                    <img src="{{ $review['user_avatar'] ?? 'https://via.placeholder.com/40x40/4ade80/ffffff?text=' . substr($review['user_name'], 0, 1) }}" 
                                         alt="User" class="w-10 h-10 rounded-full mr-3">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-1">
                                            <span class="font-semibold mr-2">{{ $review['user_name'] }}</span>
                                            <div class="flex text-yellow-500">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review['rating'])
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-gray-700">{{ $review['comment'] }}</p>
                                        <p class="text-gray-500 text-sm mt-1">{{ $review['created_at'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if(count($product->reviews) > 3)
                            <button class="mt-4 text-green-700 hover:underline">Lihat semua ulasan</button>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

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
                // Remove selection from all variations
                document.querySelectorAll('[data-variation-name]').forEach(btn => {
                    btn.classList.remove('variation-selected');
                });
                
                // Add selection to clicked variation
                this.classList.add('variation-selected');
                
                // Update price
                currentPriceAdjustment = parseInt(this.dataset.variationPriceAdjustment) || 0;
                updatePrice();
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
            document.getElementById('detail-product-price').textContent = 'Rp. ' + newPrice.toLocaleString('id-ID');
        }

        // Add to cart functionality
        document.getElementById('addToCartBtn').addEventListener('click', function() {
            const quantity = parseInt(document.getElementById('quantity').value);
            const selectedVariation = document.querySelector('.variation-selected');
            const variationName = selectedVariation ? selectedVariation.dataset.variationName : null;
            
            // You can make an AJAX call to add to cart here
            // For now, we'll just update the UI
            cartCount += quantity;
            document.getElementById('cartBadge').textContent = cartCount;
            
            // Add animation to cart icon
            const cartIcon = document.querySelector('.fa-shopping-cart');
            cartIcon.classList.add('cart-animation');
            setTimeout(() => {
                cartIcon.classList.remove('cart-animation');
            }, 500);
            
            // Show success message
            alert('Produk berhasil ditambahkan ke keranjang!');
        });

        // Buy now functionality
        document.getElementById('buyNowBtn').addEventListener('click', function() {
            const selectedVariation = document.querySelector('.variation-selected');
            const variationName = selectedVariation ? selectedVariation.dataset.variationName : 'Default';
            const quantity = document.getElementById('quantity').value;
            const totalPrice = (basePrice + currentPriceAdjustment) * quantity;
            
            alert(`Melanjutkan ke pembayaran:\nProduk: {{ $product->product_name }} ${variationName !== 'Default' ? '(' + variationName + ')' : ''}\nJumlah: ${quantity}\nTotal: Rp. ${totalPrice.toLocaleString('id-ID')}`);
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.trim();
            const resultsDiv = document.getElementById('searchResults');
            
            if (query.length > 2) {
                // You can implement AJAX search here
                // For now, hiding results
                resultsDiv.style.display = 'none';
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
    </script>
</body>
</html>