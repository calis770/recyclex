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

        .page-title {
            font-size: 24px;
            font-weight: bold;
            color: #2b5329;
            margin-bottom: 30px;
            border-bottom: 2px solid #2b5329;
            padding-bottom: 10px;
        }
    </style>
</head>
<body class="bg-green-100 font-roboto">
    <header class="bg-green-200 p-4 flex justify-between items-center">
        <div class="flex items-center">
            <a href="homepage" class="flex items-center hover:opacity-80 transition-opacity">
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
                <span class="username" style="font-size: 12px;"></span>
                <span class="edit-profile">Edit Profile</span>
            </div>
            <div class="menu-item">
                <a href="profilepage"><span class="menu-icon"><i class="fas fa-user"></i></span> My Account</a>
            </div>
            <div class="indented menu-item">
                <a href="profilepage">Profile</a>
            </div>
            <div class="indented menu-item">
                <a href="#">Update Password</a>
            </div>
            <div class="menu-item">
                <a href="myorderpage"><span class="menu-icon"><i class="fas fa-file-alt"></i></span> My Order</a>
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
            <div class="page-title">My Coins</div>

            <div class="coin-display">
                <div class="coin-icon">$</div>
                <div class="coin-value">0</div>
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
                    <div class="item-date">16-06-2025 18:43</div>
                </div>
                <div class="item-value">-2,500</div>
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