<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RecycleX - My Order</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: rgb(220, 252, 231);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
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

    .main-wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .main-content {
      display: flex;
      flex: 1;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      gap: 20px;
      min-height: calc(100vh - 300px);
    }

    .sidebar {
      width: 200px;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      height: fit-content;
    }

    .sidebar-item {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      padding: 12px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      color: inherit;
    }

    .sidebar-item:hover {
      background-color: #f0f8f0;
      transform: translateX(5px);
    }

    .sidebar-icon {
      width: 20px;
      margin-right: 12px;
      text-align: center;
      color: #2b5329;
    }

    .sidebar-text {
      font-size: 14px;
      color: #333;
      font-weight: 500;
    }

    .content-area {
      flex: 1;
      padding: 30px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      overflow-y: auto;
    }

    .nav-tabs {
      display: flex;
      border-bottom: 2px solid #e0e0e0;
      margin-bottom: 30px;
      overflow-x: auto;
    }

    .nav-tab {
      padding: 15px 20px;
      margin-right: 10px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      border-bottom: 3px solid transparent;
      transition: all 0.3s ease;
      white-space: nowrap;
    }

    .nav-tab:hover {
      background-color: #f0f8f0;
    }

    .nav-tab.active {
      border-bottom: 3px solid #2b5329;
      color: #2b5329;
      background-color: #f0f8f0;
    }

    .tab-pane {
      display: none;
    }

    .tab-pane.active {
      display: block;
      animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .order-card {
      border: 1px solid #e0e0e0;
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 25px;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .order-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 10px;
    }

    .merchant-name {
      font-size: 18px;
      font-weight: 600;
      color: #2b5329;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .order-status {
      background-color: #e8f5e8;
      color: #2b5329;
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 600;
      border: 1px solid #2b5329;
    }

    .order-details {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .product-image {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
      flex-shrink: 0;
    }

    .product-info {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .product-name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 8px;
      color: #333;
    }

    .product-description {
      font-size: 14px;
      color: #666;
      margin-bottom: 5px;
      line-height: 1.4;
    }

    .product-price {
      font-size: 18px;
      font-weight: 600;
      color: #2b5329;
      text-align: right;
      align-self: flex-start;
    }

    .order-status-info {
      font-size: 13px;
      color: #666;
      margin-bottom: 15px;
      padding: 10px;
      background-color: #f8f9fa;
      border-radius: 6px;
    }

    .order-total {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 20px;
      border-top: 2px solid #e0e0e0;
    }

    .total-label {
      font-size: 16px;
      font-weight: 500;
      color: #333;
    }

    .total-amount {
      font-size: 18px;
      font-weight: 700;
      color: #2b5329;
    }

    /* Empty state styling */
    .empty-state {
      text-align: center;
      padding: 40px 20px;
      color: #666;
    }

    .empty-state i {
      font-size: 48px;
      color: #ccc;
      margin-bottom: 20px;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .main-content {
        flex-direction: column;
        padding: 15px;
      }

      .sidebar {
        width: 100%;
        margin-bottom: 20px;
      }

      .sidebar-item {
        justify-content: center;
        text-align: center;
      }

      .order-details {
        flex-direction: column;
      }

      .product-price {
        text-align: left;
        margin-top: 10px;
      }

      .order-header {
        flex-direction: column;
        align-items: flex-start;
      }

      .header-actions {
        width: 100%;
        justify-content: space-between;
      }

      .nav-tabs {
        flex-wrap: wrap;
      }

      .nav-tab {
        margin-bottom: 5px;
      }
    }
  </style>
</head>
<body class="bg-green-100 font-roboto">
  <div class="main-wrapper">
    <!-- Updated Header to match home page -->
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
      </div>
      <div class="flex items-center space-x-4">
        <div class="relative">
          <input id="searchInput" class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text"/>
          <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
          <div id="searchResults" class="search-results"></div>
        </div>
        <a href="{{ route('productcart') }}" class="fas fa-shopping-cart text-green-700 text-2xl"></a>
        
        <!-- Profile dropdown -->
        <div class="profile-dropdown">
            <div class="profile-button flex items-center" onclick="toggleDropdown()">
                <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
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

    <div class="main-content">
      <div class="sidebar">
        <a href="#" class="sidebar-item">
          <span class="sidebar-icon"><i class="fas fa-user"></i></span>
          <div class="sidebar-text">My Account</div>
        </a>
        <a href="#" class="sidebar-item">
          <span class="sidebar-icon"><i class="fas fa-file-alt"></i></span>
          <div class="sidebar-text">My Order</div>
        </a>
        <a href="#" class="sidebar-item">
          <span class="sidebar-icon"><i class="fas fa-trophy"></i></span>
          <div class="sidebar-text">Rewards</div>
        </a>
      </div>

      <div class="content-area">
        <div class="nav-tabs">
          <div class="nav-tab active" data-tab="all">ALL</div>
          <div class="nav-tab" data-tab="unpaid">UNPAID</div>
          <div class="nav-tab" data-tab="packed">PACKED</div>
          <div class="nav-tab" data-tab="sent">SENT</div>
          <div class="nav-tab" data-tab="done">DONE</div>
          <div class="nav-tab" data-tab="cancelled">CANCELLED</div>
        </div>

        <div id="tab-content">
          <div class="tab-pane active" id="tab-all">
            <!-- Orders will be populated here -->
          </div>
          <div class="tab-pane" id="tab-unpaid">
            <div class="empty-state">
              <i class="fas fa-credit-card"></i>
              <p>Belum ada pesanan yang belum dibayar.</p>
            </div>
          </div>
          <div class="tab-pane" id="tab-packed">
            <div class="empty-state">
              <i class="fas fa-box"></i>
              <p>Pesanan Anda sedang dikemas.</p>
            </div>
          </div>
          <div class="tab-pane" id="tab-sent">
            <div class="empty-state">
              <i class="fas fa-truck"></i>
              <p>Pesanan Anda sedang dalam perjalanan.</p>
            </div>
          </div>
          <div class="tab-pane" id="tab-done">
            <div class="empty-state">
              <i class="fas fa-check-circle"></i>
              <p>Semua pesanan sudah selesai.</p>
            </div>
          </div>
          <div class="tab-pane" id="tab-cancelled">
            <div class="empty-state">
              <i class="fas fa-times-circle"></i>
              <p>Tidak ada pesanan yang dibatalkan saat ini.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Updated Footer to match home page -->
  <footer class="bg-green-200 p-6">
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
    const tabs = document.querySelectorAll('.nav-tab');
    const panes = document.querySelectorAll('.tab-pane');
    const allOrdersContainer = document.getElementById('tab-all');

    // Sample orders data for demonstration
    const sampleOrders = [
      {
        merchant: "EcoMart Indonesia",
        status: "DELIVERED",
        image: "https://via.placeholder.com/120x120/22c55e/ffffff?text=ECO",
        name: "Recycled Paper Notebook",
        description1: "Notebook made from 100% recycled paper",
        description2: "A5 Size, 100 pages, Eco-friendly binding",
        price: "Rp 25,000",
        statusInfo: "Pesanan telah diterima pada 15 Juni 2025",
        total: "Rp 28,000"
      },
      {
        merchant: "Green Solutions",
        status: "IN TRANSIT",
        image: "https://via.placeholder.com/120x120/22c55e/ffffff?text=BAG",
        name: "Reusable Shopping Bag",
        description1: "Made from recycled plastic bottles",
        description2: "Durable, waterproof, foldable design",
        price: "Rp 45,000",
        statusInfo: "Pesanan sedang dalam perjalanan, estimasi tiba 18 Juni 2025",
        total: "Rp 48,000"
      }
    ];

    // Function to retrieve paid orders from localStorage (fallback to sample data)
    function getPaidOrders() {
      try {
        const storedOrders = localStorage.getItem('paidOrders');
        if (storedOrders) {
          return JSON.parse(storedOrders);
        }
      } catch (error) {
        console.log('Using sample data as localStorage is not available');
      }
      return sampleOrders;
    }

    // Function to display an order card
    function displayOrder(order) {
      const orderCard = document.createElement('div');
      orderCard.classList.add('order-card');
      orderCard.innerHTML = `
        <div class="order-details">
          <img src="${order.image}" alt="Product" class="product-image">
          <div class="product-info">
            <div class="product-name">${order.name}</div>
            <div class="product-description">${order.description1}</div>
            <div class="product-description">${order.description2}</div>
          </div>
          <div class="product-price">${order.price}</div>
        </div>
        <div class="order-status-info">${order.statusInfo}</div>
        <div class="order-total">
          <div class="total-label">Total :</div>
          <div class="total-amount">${order.total}</div>
        </div>
      `;
      allOrdersContainer.appendChild(orderCard);
    }

    // Function to display paid orders on the "ALL" tab
    function displayPaidOrders() {
      const paidOrders = getPaidOrders();
      allOrdersContainer.innerHTML = ''; // Clear existing content
      if (paidOrders.length > 0) {
        paidOrders.forEach(order => {
          displayOrder(order);
        });
      } else {
        allOrdersContainer.innerHTML = `
          <div class="empty-state">
            <i class="fas fa-shopping-bag"></i>
            <p>Belum ada pesanan yang dibayar.</p>
          </div>
        `;
      }
    }

    // Tab switching functionality
    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        panes.forEach(p => p.classList.remove('active'));

        tab.classList.add('active');
        const targetId = 'tab-' + tab.getAttribute('data-tab');
        const target = document.getElementById(targetId);
        target.classList.add('active');

        // If the "ALL" tab is clicked, re-display paid orders
        if (targetId === 'tab-all') {
          displayPaidOrders();
        }
      });
    });

    // Initialize orders when page loads
    document.addEventListener('DOMContentLoaded', displayPaidOrders);

    // Header functionality from home page
    let allProducts = [];
    let isSearchActive = false;

    // Search functionality placeholders
    function performSearch(query) {
      console.log('Search functionality can be implemented here');
    }

    function clearSearch() {
      const searchInput = document.getElementById('searchInput');
      const searchResults = document.getElementById('searchResults');
      
      searchInput.value = '';
      searchResults.style.display = 'none';
    }

    // Event listeners for search
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      
      // Search on Enter key
      searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          performSearch(this.value);
          document.getElementById('searchResults').style.display = 'none';
        }
      });
      
      // Hide search results when clicking outside
      document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
          document.getElementById('searchResults').style.display = 'none';
        }
      });
    });

    // Function to toggle profile dropdown
    function toggleDropdown() {
        document.getElementById("profileDropdown").classList.toggle("show");
    }
  
    // Function to handle logout
    function logout() {
        if (confirm('Are you sure you want to logout?')) {
            window.location.href = "{{ route('login') }}";
        }
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