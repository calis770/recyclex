<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
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
    </i>
    <a href="{{ route('profilepage') }}" class="flex items-center">
     <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
     </span>
     </a>
    </div>
   </div>
  </header>

 <!-- Main Content -->
 <main class="max-w-4xl mx-auto my-6 px-4">
    <!-- Product Cart Section -->
    <section class="bg-white p-6 rounded-lg shadow-md mb-4">
      <h2 class="text-2xl font-bold text-green-800 mb-6">
        Product Cart
      </h2>
      
      <!-- Empty cart message (will be hidden when items exist) -->
      <div id="empty-cart-message" class="py-8 text-center text-gray-500">
        Your cart is empty. Start shopping to add items to your cart.
        <div class="mt-4">
          <a href="{{ route('homepage') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg">
            Continue Shopping
          </a>
        </div>
      </div>
      
      <!-- Cart items container -->
      <div id="cart-items-container">
        <!-- Store Selection -->
        <div class="py-3 border-b">
          <label class="flex items-center cursor-pointer">
            <input type="checkbox" id="store-checkbox" class="mr-2 form-checkbox h-5 w-5 text-green-600" checked>
            <span class="font-medium">Select All</span>
          </label>
        </div>
        
        <!-- Cart items will be inserted here by JavaScript -->
        <div id="cart-items">
          <!-- This is a template for cart items, will be filled by JS -->
        </div>
      </div>
      
      <!-- Total section -->
      <div id="cart-total" class="mt-6 py-4 border-t">
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
    
    <!-- Voucher Section -->
    <section class="bg-white p-4 rounded-lg shadow-md">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <span class="text-green-800 mr-2">
            <i class="fas fa-ticket-alt"></i>
          </span>
          <span class="text-gray-700">Tersedia Voucher Diskon s/d 50%</span>
        </div>
        <a href="{{ route('rewardspage') }}" class="text-green-800 hover:underline">Voucher Lainnya</a>
      </div>
    </section>
  </main>
  
  <!-- Footer -->
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

  <!-- JavaScript for cart handling -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get elements
      const cartBadge = document.getElementById('cartBadge');
      const cartItemsContainer = document.getElementById('cart-items-container');
      const cartItems = document.getElementById('cart-items');
      const emptyCartMessage = document.getElementById('empty-cart-message');
      const cartTotal = document.getElementById('cart-total');
      const totalPriceElement = document.getElementById('total-price');
      const storeCheckbox = document.getElementById('store-checkbox');
      
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
      
      // Handle empty cart
      if (items.length === 0) {
        cartItemsContainer.style.display = 'none';
        emptyCartMessage.style.display = 'block';
        cartTotal.style.display = 'none';
      } else {
        cartItemsContainer.style.display = 'block';
        emptyCartMessage.style.display = 'none';
        cartTotal.style.display = 'block';
        
        // Render cart items
        renderCartItems(items);
        
        // Calculate and display total
        updateTotal();
      }
      
      // Function to parse price from string to number
      function parsePrice(priceString) {
        if (!priceString) return 0;
        
        // Remove currency symbol and format characters
        const cleanPrice = priceString.toString().replace(/[^\d,.-]/g, '');
        
        // Handle Indonesian format (replace dots for thousands, comma for decimal)
        return parseFloat(cleanPrice.replace(/\./g, '').replace(',', '.'));
      }
      
      // Function to render cart items
      function renderCartItems(items) {
        cartItems.innerHTML = '';
        
        items.forEach((item, index) => {
          const itemElement = document.createElement('div');
          itemElement.className = 'py-6 flex items-center border-b';
          itemElement.innerHTML = `
            <input type="checkbox" class="mr-4 form-checkbox h-5 w-5 text-green-600 item-checkbox" data-index="${index}" checked>
            
            <div class="flex flex-1 items-start">
              <img src="${item.image || '/placeholder-image.jpg'}" alt="${item.title}" class="w-28 h-28 object-cover rounded-lg mr-6">
              
              <div class="flex-1">
                <h3 class="font-bold text-lg text-gray-800">${item.title}</h3>
                <p class="text-gray-600">${item.description || ''}</p>
                <p class="text-gray-600">Variasi: ${item.variant || ''}</p>
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
          
          cartItems.appendChild(itemElement);
        });
        
        // Add event listeners for quantity buttons
        document.querySelectorAll('.decrement-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            if (items[index].quantity > 1) {
              items[index].quantity--;
              document.querySelectorAll('.quantity-input')[index].value = items[index].quantity;
              updateLocalStorage();
              updateTotal();
            }
          });
        });
        
        document.querySelectorAll('.increment-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            items[index].quantity++;
            document.querySelectorAll('.quantity-input')[index].value = items[index].quantity;
            updateLocalStorage();
            updateTotal();
          });
        });
        
        // Add event listeners for item checkboxes
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
          checkbox.addEventListener('change', function() {
            updateTotal();
          });
        });
        
        // Add event listeners for remove buttons
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            const quantity = items[index].quantity;
            
            // Update cart count
            cartCount -= quantity;
            cartBadge.textContent = cartCount;
            
            // Remove item from array
            items.splice(index, 1);
            
            // Update localStorage
            updateLocalStorage();
            
            // Re-render cart
            if (items.length === 0) {
              cartItemsContainer.style.display = 'none';
              emptyCartMessage.style.display = 'block';
              cartTotal.style.display = 'none';
            } else {
              renderCartItems(items);
              updateTotal();
            }
          });
        });
      }
      
      // Add event listener for store checkbox
      storeCheckbox.addEventListener('change', function() {
        // Update all item checkboxes to match store checkbox
        document.querySelectorAll('.item-checkbox').forEach(checkbox => {
          checkbox.checked = this.checked;
        });
        
        // Update total
        updateTotal();
      });
      
      // Function to format currency
      function formatCurrency(value) {
        // If value is already formatted, return it
        if (typeof value === 'string' && value.includes('Rp')) {
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
      
      // Function to update total price
      function updateTotal() {
        let total = 0;
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const storeChecked = storeCheckbox.checked;
        
        if (storeChecked) {
          checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
              const price = parsePrice(items[index].price);
              const quantity = items[index].quantity;
              total += price * quantity;
            }
          });
        }
        
        // Format total price to currency format
        totalPriceElement.textContent = formatCurrency(total);
      }
      
      // Function to update localStorage
      function updateLocalStorage() {
        localStorage.setItem('cartItems', JSON.stringify(items));
        localStorage.setItem('cartCount', cartCount);
      }
      
      // Initialize checkout button
      const checkoutButton = document.getElementById('checkout-button');
      
      checkoutButton.addEventListener('click', function() {
        // Check if any items are selected
        const anySelected = document.querySelectorAll('.item-checkbox:checked').length > 0;
        
        if (!anySelected) {
          alert('Please select at least one item to checkout.');
          return;
        }
        
        // Get selected items
        const selectedItems = [];
        document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
          const index = parseInt(checkbox.getAttribute('data-index'));
          selectedItems.push(items[index]);
        });
        
        // Encode cart data for URL transfer
        const encodedCartData = encodeURIComponent(JSON.stringify(selectedItems));
        
        // Redirect to payment page with cart data
        window.location.href = "{{ route('paymentpage') }}?cart=" + encodedCartData;
      });
    });
  </script>
</body>
</html>