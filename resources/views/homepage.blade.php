<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
    RecycleX
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
    body {
        font-family: 'Roboto', sans-serif;
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

    .hidden {
        display: none !important;
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
<section id="categorySection" class="bg-white p-4 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-bold text-green-800 mb-4 text-center">Category</h2>
    <div class="flex justify-center">
        <div class="flex space-x-4">
            <div class="flex-none transition-transform transform hover:scale-95 hover:shadow-lg cursor-pointer" onclick="filterByCategory('Pakaian Wanita')">
                <div class="w-48 h-72 bg-gradient-to-br from-pink-200 to-purple-300 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tshirt text-6xl text-purple-600"></i>
                </div>
                <p class="text-center mt-2">Pakaian Wanita</p>
            </div>
            <div class="flex-none transition-transform transform hover:scale-95 hover:shadow-lg cursor-pointer" onclick="filterByCategory('Aksesoris Rumah')">
                <div class="w-48 h-72 bg-gradient-to-br from-yellow-200 to-orange-300 rounded-lg flex items-center justify-center">
                    <i class="fas fa-home text-6xl text-orange-600"></i>
                </div>
                <p class="text-center mt-2">Aksesoris Rumah</p>
            </div>
            <div class="flex-none transition-transform transform hover:scale-95 hover:shadow-lg cursor-pointer" onclick="filterByCategory('Tas')">
                <div class="w-48 h-72 bg-gradient-to-br from-blue-200 to-indigo-300 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-6xl text-indigo-600"></i>
                </div>
                <p class="text-center mt-2">Tas Wanita</p>
            </div>
            <div class="flex-none transition-transform transform hover:scale-95 hover:shadow-lg cursor-pointer" onclick="filterByCategory('Perlengkapan Rumah')">
                <div class="w-48 h-72 bg-gradient-to-br from-green-200 to-teal-300 rounded-lg flex items-center justify-center">
                    <i class="fas fa-couch text-6xl text-teal-600"></i>
                </div>
                <p class="text-center mt-2">Perlengkapan Rumah</p>
            </div>
        </div>
    </div>
</section>

<section id="searchResultsSection" class="hidden mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-green-800">Search Results</h2>
        <button onclick="clearSearch()" class="text-green-700 hover:text-green-900 underline">Show All Products</button>
    </div>
    <div id="searchResultsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    </div>
</section>

<section id="productsSection" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    {{-- Memastikan $products ada dan tidak kosong --}}
    @if(isset($products) && $products->count() > 0)
        @foreach ($products as $product)
            {{-- Menggunakan route helper untuk link ke productdetail dengan ID yang benar --}}
            <a href="{{ route('productdetail', ['id' => $product->product_id]) }}" 
               class="product-item bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg" 
               data-id="{{ $product->product_id }}"
               data-name="{{ $product->product_name }}" 
               data-category="{{ $product->category ?? 'Uncategorized' }}"
               data-umkm="{{ $product->umkm ?? 'Unknown' }}"
               data-price="{{ $product->price }}"
               data-image="{{ asset('storage/' . $product->image_product) }}"
               data-rating="{{ $product->rating ?? 0 }}"
               data-sold="{{ $product->sold ?? 0 }}"
               data-description="{{ $product->description ?? '' }}">
                
                {{-- Pastikan path gambar sudah benar --}}
                <img alt="{{ $product->product_name }}" class="w-full h-48 object-cover rounded-lg" 
                     src="{{ asset('storage/' . $product->image_product) }}"
                     width="200" height="200"/>
                
                <div class="mt-2">
                    <h3 class="text-lg font-bold">{{ $product->product_name }}</h3>
                    <p class="text-green-800">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="ml-1">{{ number_format($product->rating ?? 0, 1) }}</span>
                        <span class="ml-2">{{ ($product->sold ?? 0) > 1000 ? number_format($product->sold / 1000, 0) . 'rb+' : ($product->sold ?? 0) }} terjual</span>
                        <span class="ml-2">{{ $product->umkm ?? 'Unknown' }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    @else
        <div class="col-span-full text-center py-8 text-gray-600">
            @if(isset($products))
                Belum ada produk yang tersedia saat ini.
            @else
                Loading products...
            @endif
        </div>
    @endif
</section>
</main>

<script>
    let allProducts = [];
    let isSearchActive = false;

    // Initialize products data from the rendered HTML
    function initializeProducts() {
        const productElements = document.querySelectorAll('.product-item');
        allProducts = Array.from(productElements).map(element => ({
            element: element,
            id: element.dataset.id,
            name: element.dataset.name,
            category: element.dataset.category,
            umkm: element.dataset.umkm,
            price: parseInt(element.dataset.price),
            image: element.dataset.image,
            rating: parseFloat(element.dataset.rating),
            sold: parseInt(element.dataset.sold),
            href: element.href,
            description: element.dataset.description
        }));
    }

    // Function to render a product card for search results
    function renderProductCard(product) {
        return `
            <a href="${product.href}" class="product-item bg-white p-4 rounded-lg shadow-md flex-none transition-transform transform hover:scale-95 hover:shadow-lg">
                <img alt="${product.name}" class="w-full h-48 object-cover rounded-lg" 
                     src="${product.image}"
                     width="200" height="200"/>
                <div class="mt-2">
                    <h3 class="text-lg font-bold">${product.name}</h3>
                    <p class="text-green-800">Rp. ${new Intl.NumberFormat('id-ID').format(product.price)}</p>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="ml-1">${product.rating.toFixed(1)}</span>
                        <span class="ml-2">${product.sold > 1000 ? (product.sold / 1000).toFixed(0) + 'rb+' : product.sold} terjual</span>
                        <span class="ml-2">${product.umkm}</span>
                    </div>
                </div>
            </a>
        `;
    }

    // Search functionality
    function performSearch(query) {
        if (!query.trim()) {
            clearSearch();
            return;
        }

        const searchTerm = query.toLowerCase();
        const results = allProducts.filter(product => 
            product.name.toLowerCase().includes(searchTerm) ||
            product.category.toLowerCase().includes(searchTerm) ||
            product.umkm.toLowerCase().includes(searchTerm)
        );

        displaySearchResults(results, query);
    }

    function displaySearchResults(results, query) {
        const searchResultsSection = document.getElementById('searchResultsSection');
        const searchResultsGrid = document.getElementById('searchResultsGrid');
        const productsSection = document.getElementById('productsSection');
        
        // Clear previous results
        searchResultsGrid.innerHTML = '';
        
        if (results.length === 0) {
            searchResultsGrid.innerHTML = `
                <div class="col-span-full text-center py-8">
                    <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 text-lg">No products found for "${query}"</p>
                    <p class="text-gray-500 text-sm mt-2">Try searching with different keywords</p>
                </div>
            `;
        } else {
            results.forEach(product => {
                searchResultsGrid.innerHTML += renderProductCard(product);
            });
        }
        
        // Show search results section and hide main products
        searchResultsSection.classList.remove('hidden');
        productsSection.classList.add('hidden');
        isSearchActive = true;
    }

    function clearSearch() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchResultsSection = document.getElementById('searchResultsSection');
        const productsSection = document.getElementById('productsSection');
        
        searchInput.value = '';
        searchResults.style.display = 'none';
        searchResultsSection.classList.add('hidden');
        productsSection.classList.remove('hidden');
        isSearchActive = false;
    }

    function showQuickSearchResults(query) {
        const searchResults = document.getElementById('searchResults');
        
        if (!query.trim()) {
            searchResults.style.display = 'none';
            return;
        }

        const searchTerm = query.toLowerCase();
        const results = allProducts.filter(product => 
            product.name.toLowerCase().includes(searchTerm) ||
            product.category.toLowerCase().includes(searchTerm) ||
            product.umkm.toLowerCase().includes(searchTerm)
        ).slice(0, 5);

        if (results.length === 0) {
            searchResults.innerHTML = `
                <div class="search-result-item text-gray-500">
                    No products found for "${query}"
                </div>
            `;
        } else {
            searchResults.innerHTML = results.map(product => `
                <div class="search-result-item" onclick="selectQuickResult('${product.name}')">
                    <div class="font-medium">${product.name}</div>
                    <div class="text-sm text-gray-600">${product.category} • ${product.umkm}</div>
                </div>
            `).join('');
        }
        
        searchResults.style.display = 'block';
    }

    function selectQuickResult(productName) {
        const searchInput = document.getElementById('searchInput');
        searchInput.value = productName;
        performSearch(productName);
        document.getElementById('searchResults').style.display = 'none';
    }

    // Filter by category function
    function filterByCategory(category) {
        const results = allProducts.filter(product => 
            product.category === category || 
            (category === 'Tas' && product.category === 'Tas Wanita')
        );
        
        displaySearchResults(results, category);
        document.getElementById('searchInput').value = category;
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        initializeProducts();
        
        const searchInput = document.getElementById('searchInput');
        
        // Real-time search as user types
        searchInput.addEventListener('input', function() {
            const query = this.value;
            showQuickSearchResults(query);
        });
        
        // Search on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch(this.value);
                document.getElementById('searchResults').style.display = 'none';
            }
        });
        
        // Hide quick search results when clicking outside
        document.addEventListener('click', function(e) {
            const searchContainer = document.querySelector('.relative');
            if (searchContainer && !searchContainer.contains(e.target)) {
                document.getElementById('searchResults').style.display = 'none';
            }
        });
    });

    // Function to toggle profile dropdown
    function toggleDropdown() {
        document.getElementById("profileDropdown").classList.toggle("show");
    }
    
    // Close dropdown when clicking outside
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