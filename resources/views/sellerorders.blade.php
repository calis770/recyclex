<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RecycleX - My Seller Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        /* Reusing styles from the user's my order page */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: rgb(240, 255, 240);
        }

        .main-content {
            display: flex;
            height: auto; /* Adjust height for content */
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            gap: 20px;
        }

        .sidebar {
            width: 150px;
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 6px 0;
            border-radius: 5px;
            cursor: pointer;
        }

        .sidebar-item:hover {
            background-color: #f5f5f5;
        }

        .sidebar-icon {
            width: 16px;
            margin-right: 8px;
            text-align: center;
            color: #666;
        }

        .sidebar-text {
            font-size: 13px;
            color: #333;
        }

        .content-area {
            flex-grow: 1;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .nav-tabs {
            display: flex;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .nav-tab {
            padding: 10px 15px;
            margin-right: 5px;
            font-size: 14px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }

        .nav-tab.active {
            border-bottom: 2px solid #2b5329;
            font-weight: 500;
        }

        .tab-pane {
            display: none;
        }

        .tab-pane.active {
            display: block;
        }

        .order-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .buyer-name {
            font-size: 16px;
            font-weight: 500;
        }

        .contact-btn {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 5px 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-left: 10px;
            margin-right: auto;
        }

        .contact-icon {
            margin-right: 5px;
        }

        .order-status {
            background-color: #f5f5f5;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
        }

        .order-details {
            display: flex;
        }

        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-name {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .product-quantity {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .product-price {
            font-size: 16px;
            font-weight: 500;
            text-align: right;
        }

        .order-status-actions {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
            text-align: left;
        }

        .order-total {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .total-label, .total-amount {
            font-size: 14px;
            font-weight: 500;
        }

        /* Seller specific order actions */
        .seller-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .seller-action-btn {
            background-color: #2b5329;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s;
        }

        .seller-action-btn:hover {
            background-color: #1e3b1d;
        }

        .seller-action-btn.secondary {
            background-color: #f0ad4e; /* Example: Warning color for "Process" */
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <header class="bg-green-200 p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img alt="RecycleX logo" class="h-12 w-12" src="{{ asset('Assets/logo.png') }}" />
            <div class="ml-2">
                <a class="text-sm text-green-700" href="#">Download RecycleX App</a>
                <h1 class="text-3xl font-bold text-green-700">RecycleX</h1>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text" />
                <i class="fas fa-search text-gray-400 absolute left-3 top-3"></i>
            </div>
            <a href="{{ route('productcart') }}"
               class="fas fa-shopping-cart text-green-700 text-2xl"></i>
            </a>
            </i>
            <a href="{{ route('profilepage') }}" class="flex items-center">
               <img alt="User profile picture" class="h-10 w-10 rounded-full" height="40" src="{{ asset('Assets/profile.jpg') }}" width="40"/>
               </span>
            </a>
        </div>
    </header>

    <div class="main-content">
        <div class="sidebar">
            <a href="{{ route('profilepage') }}" class="sidebar-item">
                <span class="sidebar-icon"><i class="fas fa-user"></i></span>
                <div class="sidebar-text">My Account</div>
            </a>
            <a href="{{ route('myshoppage') }}" class="sidebar-item">
                <span class="sidebar-icon"><i class="fas fa-store"></i></span>
                <div class="sidebar-text">My Shop</div>
            </a>
            <a href="{{ route('productspage') }}" class="sidebar-item">
                <span class="sidebar-icon"><i class="fas fa-box"></i></span>
                <div class="sidebar-text">Products</div>
            </a>
            <a href="{{ route('sellerorders') }}" class="sidebar-item active">
                <span class="sidebar-icon"><i class="fas fa-truck"></i></span>
                <div class="sidebar-text">Seller Orders</div>
            </a>
        </div>

        <div class="content-area">
            <div class="nav-tabs">
                <div class="nav-tab active" data-tab="all">ALL</div>
                <div class="nav-tab" data-tab="pending">PENDING</div>
                <div class="nav-tab" data-tab="processing">PROCESSING</div>
                <div class="nav-tab" data-tab="shipped">SHIPPED</div>
                <div class="nav-tab" data-tab="completed">COMPLETED</div>
                <div class="nav-tab" data-tab="cancelled">CANCELLED</div>
            </div>

            <div id="tab-content">
                <div class="tab-pane active" id="tab-all">
                    <div class="order-card">
                        <div class="order-header">
                            <div class="buyer-name">Budi Santoso</div>
                            <button class="contact-btn"><span class="contact-icon">💬</span> Chat</button>
                            <div class="order-status">PENDING</div>
                        </div>
                        <div class="order-details">
                            <img src="{{ asset('Assets/totebag biru.jpg') }}" alt="Product" class="product-image">
                            <div class="product-info">
                                <div class="product-name">Totebag Batik</div>
                                <div class="product-quantity">Jumlah: 1</div>
                                <div class="product-price">Rp. 54.000,00</div>
                            </div>
                            <div class="product-price">Rp. 54.000,00</div>
                        </div>
                        <div class="order-status-actions">Pesanan dibuat pada 15 April 2025</div>
                        <div class="order-total">
                            <div class="total-label">Total Pesanan:</div>
                            <div class="total-amount">Rp. 54.000,00</div>
                        </div>
                        <div class="seller-actions">
                            <button class="seller-action-btn secondary">Process Order</button>
                            <button class="seller-action-btn">Contact Buyer</button>
                            <button class="seller-action-btn">Cancel Order</button>
                        </div>
                    </div>
                    </div>

                <div class="tab-pane" id="tab-pending">
                    <p>No pending orders at the moment.</p>
                </div>
                <div class="tab-pane" id="tab-processing">
                    <p>Orders being processed will appear here.</p>
                </div>
                <div class="tab-pane" id="tab-shipped">
                    <p>List of shipped orders.</p>
                </div>
                <div class="tab-pane" id="tab-completed">
                    <p>Successfully completed orders.</p>
                </div>
                <div class="tab-pane" id="tab-cancelled">
                    <p>Cancelled orders will be shown here.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-green-200 p-6 mt-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">About RecycleX</h3>
                <p class="text-green-800">RecycleX is a marketplace platform that connects consumers with local UMKM (Micro, Small, and Medium Enterprises) that produce recycled and sustainable products.</p>
            </div>
            <div>
                <h3 class="text-lg font-bold text-green-800 mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('homeseller') }}" class="text-green-800 hover:underline">Home</a></li>
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

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                panes.forEach(p => p.classList.remove('active'));

                tab.classList.add('active');
                const target = document.getElementById('tab-' + tab.getAttribute('data-tab'));
                target.classList.add('active');
            });
        });
    </script>
</body>
</html>