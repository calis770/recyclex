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

        /* Main content and sidebar specific styles */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            display: flex;
            flex: 1;
            max-width: 1200px;
            margin: 40px auto; /* Added top/bottom margin */
            padding: 20px;
            gap: 25px; /* Increased gap */
            min-height: calc(100vh - 300px); /* Adjust based on header/footer height */
        }

        .sidebar {
            width: 250px; /* Slightly wider sidebar */
            background-color: #fff;
            padding: 25px; /* More padding */
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); /* More pronounced shadow */
            height: fit-content;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            margin-bottom: 18px; /* Increased margin */
            padding: 14px; /* More padding */
            border-radius: 10px; /* More rounded items */
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            font-weight: 500;
        }

        .sidebar-item:hover {
            background-color: #e8f5e8; /* Lighter green on hover */
            transform: translateX(8px); /* More pronounced slide effect */
            color: #2b5329;
        }

        .sidebar-item .active {
            background-color: #dcfce7; /* Distinct active background */
            color: #2b5329;
            font-weight: 700;
        }

        .sidebar-icon {
            width: 24px; /* Larger icons */
            margin-right: 15px; /* More spacing */
            text-align: center;
            color: #2b5329;
            font-size: 1.2em;
        }

        .sidebar-text {
            font-size: 16px; /* Larger font size */
            color: #333;
        }

        .content-area {
            flex: 1;
            padding: 30px;
            background-color: #fff;
            border-radius: 12px; /* More rounded corners */
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); /* More pronounced shadow */
            overflow-y: auto;
        }

        .nav-tabs {
            display: flex;
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 30px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch; /* For smoother scrolling on mobile */
            scrollbar-width: none; /* Hide scrollbar for Firefox */
        }
        .nav-tabs::-webkit-scrollbar { /* Hide scrollbar for Chrome, Safari, Edge */
            display: none;
        }

        .nav-tab {
            padding: 15px 20px;
            margin-right: 15px; /* Increased margin */
            font-size: 15px; /* Slightly larger font */
            font-weight: 500;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
            color: #555;
        }

        .nav-tab:hover {
            background-color: #f0f8f0;
            color: #2b5329;
        }

        .nav-tab.active {
            border-bottom: 3px solid #2b5329;
            color: #2b5329;
            background-color: #f0f8f0;
            font-weight: 600;
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Stronger shadow */
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .order-card:hover {
            transform: translateY(-3px); /* More pronounced lift */
            box-shadow: 0 8px 20px rgba(0,0,0,0.15); /* Stronger hover shadow */
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px; /* Increased gap */
            padding-bottom: 15px; /* Space before separator */
            border-bottom: 1px solid #f0f0f0; /* Light separator */
        }

        .merchant-name {
            font-size: 19px; /* Slightly larger */
            font-weight: 700; /* Bolder */
            color: #2b5329;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .merchant-name i {
            color: #2b5329;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .order-status {
            background-color: #dcfce7; /* Green-100 */
            color: #166534; /* Green-800 */
            padding: 8px 16px; /* More padding */
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #bbf7d0; /* Green-200 border */
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.05); /* Subtle inner shadow */
        }
        
        .order-status.PACKED { background-color: #fffbeb; color: #d97706; border-color: #fde68a; } /* Amber for packed */
        .order-status.SENT { background-color: #e0f2fe; color: #2563eb; border-color: #bfdbfe; } /* Blue for sent */
        .order-status.DONE { background-color: #dcfce7; color: #166534; border-color: #bbf7d0; } /* Green for done */
        .order-status.CANCELLED { background-color: #f3f4f6; color: #6b7280; border-color: #e5e7eb; } /* Gray for cancelled */


        .order-details {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            align-items: flex-start;
        }

        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px; /* Slightly more rounded */
            flex-shrink: 0;
            border: 1px solid #eee; /* Light border around image */
        }

        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-name {
            font-size: 19px; /* Larger product name */
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
            font-size: 19px; /* Larger product price */
            font-weight: 700;
            color: #2b5329;
            text-align: right;
            align-self: flex-start; /* Aligns to top-right of its flex container */
            white-space: nowrap; /* Prevents price from wrapping */
        }

        .order-status-info {
            font-size: 14px; /* Slightly larger font */
            color: #555;
            margin-bottom: 15px;
            padding: 12px 15px; /* More padding */
            background-color: #f8fcf8; /* Very light green background */
            border-left: 4px solid #bbf7d0; /* Left border for emphasis */
            border-radius: 6px;
            line-height: 1.5;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 2px dashed #e0e0e0; /* Dashed border for total */
            margin-top: 15px; /* Added margin-top */
        }

        .total-label {
            font-size: 17px; /* Larger font */
            font-weight: 600;
            color: #333;
        }

        .total-amount {
            font-size: 22px; /* Larger total amount */
            font-weight: 800; /* Extra bold */
            color: #166534; /* Darker green for total */
        }

        /* Empty state styling */
        .empty-state {
            text-align: center;
            padding: 60px 20px; /* More padding for empty state */
            color: #888;
        }

        .empty-state i {
            font-size: 60px; /* Larger icon */
            color: #ccc;
            margin-bottom: 25px; /* More margin */
        }
        .empty-state p {
            font-size: 18px; /* Larger text for empty state */
            color: #777;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
                padding: 15px;
                margin: 20px auto;
                gap: 15px;
            }

            .sidebar {
                width: 100%;
                margin-bottom: 15px;
                padding: 15px;
            }

            .sidebar-item {
                justify-content: center;
                text-align: center;
                padding: 10px;
                margin-bottom: 10px;
            }
            .sidebar-icon {
                margin-right: 10px;
            }
            .sidebar-text {
                font-size: 14px;
            }

            .content-area {
                padding: 20px;
            }

            .order-details {
                flex-direction: column;
                align-items: center; /* Center items in column layout */
                text-align: center;
            }

            .product-image {
                margin-bottom: 15px;
            }

            .product-info {
                align-items: center; /* Center text in product info */
            }

            .product-price {
                text-align: center; /* Center price in column layout */
                align-self: center; /* Override flex-start */
                margin-top: 10px;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .header-actions {
                width: 100%;
                justify-content: space-between;
            }

            .nav-tabs {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-tab {
                margin-bottom: 8px;
                margin-right: 8px;
                padding: 12px 15px;
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
                <a href="{{ route('profilepage') }}" class="sidebar-item">
                    <span class="sidebar-icon"><i class="fas fa-user"></i></span>
                    <div class="sidebar-text">My Account</div>
                </a>
                <a href="{{ route('myorderpage') }}" class="sidebar-item active">
                    <span class="sidebar-icon"><i class="fas fa-file-alt"></i></span>
                    <div class="sidebar-text">My Order</div>
                </a>
                <a href="{{ route('rewardspage') }}" class="sidebar-item">
                    <span class="sidebar-icon"><i class="fas fa-trophy"></i></span>
                    <div class="sidebar-text">Rewards</div>
                </a>
            </div>

            <div class="content-area">
                <div class="nav-tabs">
                    <div class="nav-tab active" data-tab="all">ALL</div>
                    <div class="nav-tab" data-tab="packed">PACKED</div>
                    <div class="nav-tab" data-tab="sent">SENT</div>
                    <div class="nav-tab" data-tab="done">DONE</div>
                    <div class="nav-tab" data-tab="cancelled">CANCELED</div>
                </div>

                <div id="tab-content">
                    <div class="tab-pane active" id="tab-all">
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
        const tabs = document.querySelectorAll('.nav-tab');
        const panes = document.querySelectorAll('.tab-pane');
        const allOrdersContainer = document.getElementById('tab-all');

        // Fungsi untuk mengambil pesanan dari localStorage
        function getOrdersFromLocalStorage() {
            try {
                const storedOrders = localStorage.getItem('paidOrders');
                if (storedOrders) {
                    return JSON.parse(storedOrders);
                }
            } catch (error) {
                console.error("Error reading or parsing paidOrders from localStorage:", error);
            }
            return []; // Kembalikan array kosong jika tidak ada atau ada error
        }

        // Fungsi untuk menampilkan kartu pesanan
        function displayOrderCard(order) {
            const orderCard = document.createElement('div');
            orderCard.classList.add('order-card');
            orderCard.innerHTML = `
                <div class="order-header">
                    <div class="merchant-name"><i class="fas fa-store"></i> ${order.merchant || "RecycleX UMKM Partner"}</div>
                    <div class="order-status ${order.status}">${order.status}</div>
                </div>
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
                    <div class="total-label">Total Pembayaran:</div>
                    <div class="total-amount">${order.total}</div>
                </div>
            `;
            return orderCard;
        }

        // Fungsi untuk menampilkan pesanan di tab yang sesuai
        function displayOrdersByStatus(statusFilter) {
            const allPaidOrders = getOrdersFromLocalStorage();
            const filteredOrders = statusFilter === 'all'
                ? allPaidOrders
                : allPaidOrders.filter(order => order.status && order.status.toLowerCase() === statusFilter);

            // Sort orders by order_date in descending order (newest first)
            filteredOrders.sort((a, b) => {
                const dateA = new Date(a.order_date);
                const dateB = new Date(b.order_date);
                return dateB - dateA;
            });

            panes.forEach(pane => pane.innerHTML = ''); // Clear all panes first

            if (filteredOrders.length > 0) {
                filteredOrders.forEach(order => {
                    document.getElementById(`tab-${statusFilter}`).appendChild(displayOrderCard(order));
                });
            } else {
                let emptyMessage = "Tidak ada pesanan.";
                let iconClass = "fas fa-shopping-bag"; 

                switch (statusFilter) {
                    case 'packed':
                        emptyMessage = "Pesanan Anda sedang dikemas.";
                        iconClass = "fas fa-box";
                        break;
                    case 'sent':
                        emptyMessage = "Pesanan Anda sedang dalam perjalanan.";
                        iconClass = "fas fa-truck";
                        break;
                    case 'done':
                        emptyMessage = "Semua pesanan sudah selesai.";
                        iconClass = "fas fa-check-circle";
                        break;
                    case 'cancelled':
                        emptyMessage = "Tidak ada pesanan yang dibatalkan saat ini.";
                        iconClass = "fas fa-times-circle";
                        break;
                    case 'all': // For 'all' if no orders at all
                        emptyMessage = "Belum ada pesanan yang tercatat.";
                        iconClass = "fas fa-shopping-bag";
                        break;
                }

                document.getElementById(`tab-${statusFilter}`).innerHTML = `
                    <div class="empty-state">
                        <i class="${iconClass}"></i>
                        <p>${emptyMessage}</p>
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
                const targetTabName = tab.getAttribute('data-tab');
                const targetPane = document.getElementById(`tab-${targetTabName}`);
                targetPane.classList.add('active');

                // Call function to display orders based on the selected tab
                displayOrdersByStatus(targetTabName);
            });
        });

        // Initialize orders when page loads (display 'ALL' tab by default)
        document.addEventListener('DOMContentLoaded', () => {
            displayOrdersByStatus('all');
        });

        // Header functionality (copied from your original code, no changes)
        let allProducts = [];
        let isSearchActive = false;

        function performSearch(query) {
            console.log('Search functionality can be implemented here');
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
                if (!e.target.closest('.relative')) {
                    document.getElementById('searchResults').style.display = 'none';
                }
            });
        });

        function toggleDropdown() {
            document.getElementById("profileDropdown").classList.toggle("show");
        }
    
       function logout() {
      if (confirm('Anda yakin ingin logout?')) {
          localStorage.removeItem('paidOrders'); 
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