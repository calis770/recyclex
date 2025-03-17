<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecycleX</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: rgb(240, 255, 240);
            margin: 0;
            padding: 0;
        }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 20px;
            background-color: #c3f0c8;
            border-bottom: 1px solid #a0e0af;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }
        
        .brand {
            font-size: 18px;
            font-weight: bold;
            color: #2b5329;
        }
        
        .download-text {
            font-size: 12px;
            color: #2b5329;
            margin-left: 10px;
        }
        
        .search-cart {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .search-bar {
            padding: 8px 12px;
            border: 1px solid #2b5329;
            border-radius: 25px;
            width: 300px;
            background-color: white;
            color: #333;
            font-size: 14px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s, border-color 0.2s;
            outline: none;
        }
        
        .search-bar:focus {
            border-color: #1e3b1d;
            box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.15);
        }
        
        .cart-icon {
            color: #753e00;
            font-size: 18px;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .user-avatar {
            width: 25px;
            height: 25px;
            border-radius: 50%;
        }
        
        .username {
            font-size: 14px;
            color: #333;
        }
        
        /* Main content */
        .main-content {
            display: flex;
            height: calc(100vh - 120px);
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
        
        /* Content area */
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
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .merchant-name {
            font-size: 16px;
            font-weight: 500;
        }
        
        .chat-btn {
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
        
        .chat-icon {
            color: #ffc107;
            margin-right: 5px;
        }
        
        .order-status {
            background-color: #f5f5f5;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .order-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
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
        
        .product-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .product-price {
            font-size: 16px;
            font-weight: 500;
            text-align: right;
        }
        
        .order-status-info {
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
        
        .total-label {
            font-size: 14px;
            font-weight: 500;
        }
        
        .total-amount {
            font-size: 16px;
            font-weight: 500;
        }
        
        .footer {
            background-color: #b8f0c7;
            height: 40px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('Assets/logo.png') }}" alt="Logo" class="logo">
            <div class="brand">RecycleX</div>
        </div>
        <div class="search-cart">
            <input type="text" class="search-bar" placeholder="Search...">
            <div class="cart-icon">🛒</div>
            <div class="user-profile">
                <img src="{{ asset('Assets/profile.jpg') }}" alt="User" class="user-avatar">
                <div class="username">calista zahra</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-item">
                <span class="sidebar-icon">👤</span>
                <div class="sidebar-text">My Account</div>
            </div>
            <div class="sidebar-item">
                <span class="sidebar-icon">📄</span>
                <div class="sidebar-text">My Order</div>
            </div>
            <div class="sidebar-item">
                <span class="sidebar-icon">🏆</span>
                <div class="sidebar-text">Rewards</div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Navigation Tabs -->
            <div class="nav-tabs">
                <div class="nav-tab active">ALL</div>
                <div class="nav-tab">UNPAID</div>
                <div class="nav-tab">PACKED</div>
                <div class="nav-tab">SENT</div>
                <div class="nav-tab">DONE</div>
                <div class="nav-tab">CANCELLED</div>
            </div>

            <!-- Order Card -->
            <div class="order-card">
                <div class="order-header">
                    <div class="merchant-name">UMKM Putri</div>
                    <button class="chat-btn">
                        <span class="chat-icon">💬</span>
                        Chat
                    </button>
                    <div class="order-status">PACKED</div>
                </div>
                <div class="order-details">
                    <img src="{{ asset('Assets/tas wanita.jpg') }}" alt="Product" class="product-image">
                    <div class="product-info">
                        <div class="product-name">Totebag Batik</div>
                        <div class="product-description">Terbuat dari kain perca.</div>
                        <div class="product-description">Cocok untuk dibawa pergi berkuliah.</div>
                    </div>
                    <div class="product-price">Rp. 54.000,00</div>
                </div>
                <div class="order-status-info">
                    Produk akan dikirimkan setelah Jum'at 29 Februari 2024
                </div>
                <div class="order-total">
                    <div class="total-label">Total :</div>
                    <div class="total-amount">54.000,00</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer"></div>
</body>
</html>