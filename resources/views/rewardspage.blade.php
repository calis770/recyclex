<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RecycleX - Rewards</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(240, 255, 240);
        }

        .main-container {
            display: flex;
            padding: 20px;
            gap: 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .sidebar {
            width: 150px;
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .content-area {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.05);
        }

        .user-avatar {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .user-avatar img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-bottom: 6px;
        }

        .edit-profile {
            color: #666;
            font-size: 11px;
            margin-top: 2px;
        }

        .menu-item {
            padding: 6px 0;
        }

        .menu-item a {
            text-decoration: none;
            color: #333;
            font-size: 13px;
            display: flex;
            align-items: center;
        }

        .menu-item.active a {
            color: #2b5329;
            font-weight: bold;
        }

        .menu-icon {
            width: 16px;
            margin-right: 8px;
            text-align: center;
            color: #666;
        }

        /* Rewards Specific Styles */
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
            transition: border-bottom 0.2s, color 0.2s;
        }

        .nav-tab:hover {
            color: #2b5329;
        }

        .nav-tab.active {
            border-bottom: 2px solid #2b5329;
            font-weight: 500;
            color: #2b5329;
        }

        .coin-display {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .coin-icon {
            width: 24px;
            height: 24px;
            background-color: #FFC107;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        .coin-value {
            font-size: 20px;
            font-weight: bold;
        }

        .deposit-btn {
            text-align: right;
            color: #2b5329;
            font-weight: bold;
            margin-bottom: 20px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .deposit-btn:hover {
            color: #1b3b19;
            text-decoration: underline;
        }

        .history-title {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .history-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            cursor: pointer;
            transition: box-shadow 0.2s;
        }

        .history-item:hover {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .item-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .item-date {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }

        .item-value {
            font-size: 16px;
            font-weight: 500;
            color: #F44336;
            text-align: right;
            align-self: center;
        }

        /* Add button styles */
        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: center;
        }

        .btn-primary {
            background-color: #2b5329;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1b3b19;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #2b5329;
            color: #2b5329;
        }

        .btn-outline:hover {
            background-color: #f0f8f0;
        }

        /* Voucher tab specific styles */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .voucher-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .voucher-input-box {
            display: flex;
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            align-items: center;
            padding: 0 10px;
        }

        .voucher-input-icon {
            font-size: 18px;
            color: #777;
            margin-right: 8px;
        }

        .voucher-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 10px 0;
            font-size: 14px;
        }

        .voucher-btn {
            flex: 1;
            text-align: center;
            padding: 10px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .voucher-btn .icon {
            margin-right: 8px;
            font-size: 18px;
            color: #777;
        }

        .voucher-item {
            background-color: #eaffef;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .voucher-left {
            display: flex;
            align-items: center;
        }

        .voucher-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .voucher-info h3 {
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .voucher-info p {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        .voucher-info .expiry {
            font-size: 11px;
            color: #777;
            margin-top: 3px;
        }

        .voucher-use {
            background-color: white;
            border: 1px solid #2b5329;
            color: #2b5329;
            padding: 6px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
        }

        .voucher-use:hover {
            background-color: #f0f8f0;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.nav-tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    tabContents.forEach(content => content.classList.remove('active'));

                    const tabName = this.textContent.trim();
                    const activeContent = document.getElementById(tabName.toLowerCase() + '-content');
                    if (activeContent) {
                        activeContent.classList.add('active');
                    }
                });
            });

            const sidebarItems = document.querySelectorAll('.sidebar-item');
            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebarItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            document.querySelector('.nav-tab.active').click();
        });
    </script>
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
                <input class="pl-8 pr-4 py-2 rounded-full border border-gray-300" placeholder="Search" type="text"/>
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
   </div>
  </header>

    <div class="main-container">
        <div class="sidebar">
            <div class="user-avatar">
                <img src="{{ asset('Assets/profile.jpg') }}" alt="User Avatar">
                <span class="username" style="font-size: 12px;">calista zahra</span>
                <span class="edit-profile">Edit Profile</span>
            </div>
            <div class="menu-item">
                <a href="#"><span class="menu-icon"><i class="fas fa-user"></i></span> My Account</a>
            </div>
            <div class="indented menu-item">
                <a href="#">Profile</a>
            </div>
            <div class="indented menu-item">
                <a href="#">Update Password</a>
            </div>
            <div class="menu-item">
                <a href="#"><span class="menu-icon"><i class="fas fa-file-alt"></i></span> My Order</a>
            </div>
            <div class="menu-item active">
                <a href="#"><span class="menu-icon"><i class="fas fa-trophy"></i></span> Rewards</a>
            </div>
            <div class="menu-item seller-menu" style="display: none;">
                <a href="#"><span class="menu-icon"><i class="fas fa-store"></i></span> My Shop</a>
            </div>
            <div class="menu-item seller-menu" style="display: none;">
                <a href="#"><span class="menu-icon"><i class="fas fa-box"></i></span> Products</a>
            </div>
        </div>

        <div class="content-area">
            <div class="nav-tabs">
                <div class="nav-tab active">VOUCHER</div>
                <div class="nav-tab">COIN</div>
            </div>

            <div id="voucher-content" class="tab-content active">
                <div class="voucher-actions">
                    <div class="voucher-input-box">
                        <span class="voucher-input-icon"><i class="fas fa-edit"></i></span>
                        <input type="text" class="voucher-input" placeholder="Enter The Voucher Code">
                    </div>
                    <div class="voucher-btn">
                        <span class="icon"><i class="fas fa-clipboard-list"></i></span>
                        <span>Get More Vouchers</span>
                    </div>
                </div>

                <div class="voucher-item">
                    <div class="voucher-left">
                        <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo" class="voucher-logo">
                        <div class="voucher-info">
                            <h3>Diskon 10% s/d Rp10RB</h3>
                            <p>Min. Spend Rp.70RB</p>
                            <p class="expiry">exp: 17-Jan</p>
                        </div>
                    </div>
                    <button class="voucher-use">Use</button>
                </div>

                <div class="voucher-item">
                    <div class="voucher-left">
                        <img src="{{ asset('Assets/logo.png') }}" alt="RecycleX Logo" class="voucher-logo">
                        <div class="voucher-info">
                            <h3>Discount 15% s/d Rp15RB</h3>
                            <p>Min. Spend Rp.100RB</p>
                            <p class="expiry">exp: 17-Jan</p>
                        </div>
                    </div>
                    <button class="voucher-use">Use</button>
                </div>
            </div>

            <div id="coin-content" class="tab-content">
                <div class="coin-display">
                    <div class="coin-icon">$</div>
                    <div class="coin-value">300</div>
                </div>

                <div class="deposit-btn">
                    <a href="{{ route('greencashpage') }}"><span>Earn Coins ></span></a>
                </div>

                <div class="history-title">My History</div>

                <div class="history-item">
                    <img src="{{ asset('Assets/sarung bantal.jpg') }}" alt="Sarung Bantal" class="item-image">
                    <div class="item-details">
                        <div class="item-name">Sarung Bantal</div>
                        <div class="item-description">Obtained by Redemption</div>
                        <div class="item-date">16-02-2020 18:43</div>
                    </div>
                    <div class="item-value">-2,500</div>
                </div>
            </div>
        </div>
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
</body>
</html>